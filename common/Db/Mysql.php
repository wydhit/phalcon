<?php
namespace Common\Db;
use Phalcon\Db\RawValue;
use Phalcon\Filter;


class Mysql extends \Phalcon\Db\Adapter\Pdo\Mysql
{

    /**
     * 对某表某字段 增加值操作
     * @param $table
     * @param null $field
     * @param int $step
     * @param $where
     * @return bool
     */
    public function increment($table, $field = null, $step = 0, $where)
    {
        return $this->fieldStep($table, $field, $step, $where, '+');
    }
    /**
     * 对某表某字段 减少值操作
     * @param $table
     * @param null $field
     * @param int $step
     * @param $where
     * @return bool
     */
    public function decrement($table, $field = null, $step = 0, $where)
    {
        return $this->fieldStep($table, $field , $step, $where, '-');
    }
    /**
     * 对某表某字段 减少值操作 但是限定不能减至0以下
     * @param $table
     * @param null $field
     * @param int $step
     * @param $where
     * @return bool
     */
    public function decrementAboveZero($table, $field = null, $step = 0, $where)
    {
        $sql="select $field from $table WHERE $where";
        $result=$this->fetchOne($sql);
        if($result[$field]<$step){
            return false;
        }else{
           return $this->decrement($table,$field,$step,$where);
        }
    }

    private function fieldStep($table, $field, $step, $where, $type = '')
    {
        $table = $this->sanitizeKey($table);
        $key = $this->sanitizeKey($field);
        if (empty($key)||empty($table)) {
            return false;
        }
        $step = (int)$step;
        if($step<0){
            return false;
        }
        if ($type === '+') {
            $value = $this->rawValue("`$key` + $step");
        } elseif ($type === '-') {
            $value = $this->rawValue("`$key` - $step");
        } else {
            return false;
        }
        $data = [$key => $value];
        return $this->updateAsDict($table, $data, $where);
    }

    private function rawValue($v)
    {
        return new RawValue($v);
    }

    private function sanitizeKey($field)
    {
        return (new Filter())->sanitize($field, 'string');
    }
    /*实验方法待用*/
    public function builder($param=[]){
        return new Query($this,$param);
    }

    public function getQueryBuilder()
    {
        return new QueryBuilder($this);
    }

    public function quoteSimpleTableName($name)
    {
        return strpos($name, '`') !== false ? $name : "`$name`";
    }
    /**
     * Quotes a column name for use in a query.
     * A simple column name has no prefix.
     * @param string $name column name
     * @return string the properly quoted column name
     */
    public function quoteSimpleColumnName($name)
    {
        return strpos($name, '`') !== false || $name === '*' ? $name : "`$name`";
    }
    public function quoteColumnName($name)
    {
        if (strpos($name, '(') !== false || strpos($name, '[[') !== false) {
            return $name;
        }
        if (($pos = strrpos($name, '.')) !== false) {
            $prefix = $this->quoteTableName(substr($name, 0, $pos)) . '.';
            $name = substr($name, $pos + 1);
        } else {
            $prefix = '';
        }
        if (strpos($name, '{{') !== false) {
            return $name;
        }
        return $prefix . $this->quoteSimpleColumnName($name);
    }
    public function quoteTableName($name)
    {
        if (strpos($name, '(') !== false || strpos($name, '{{') !== false) {
            return $name;
        }
        if (strpos($name, '.') === false) {
            return $this->quoteSimpleTableName($name);
        }
        $parts = explode('.', $name);
        foreach ($parts as $i => $part) {
            $parts[$i] = $this->quoteSimpleTableName($part);
        }

        return implode('.', $parts);

    }




}