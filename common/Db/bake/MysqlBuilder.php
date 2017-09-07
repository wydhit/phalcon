<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 17:18
 */

namespace Common\Db;

use Common\Helpers\DiHelper;
use Common\Helpers\HttpHelper;
use Phalcon\Db\Adapter\Pdo\Mysql as MysqlDb;

class MysqlBuilder
{
    private $di;
    private $isFromModel = true;
    private $db = null;
    private $select = null;
    private $from = null;
    private $join = null;
    private $where = null;
    private $order = null;
    private $limit = null;
    private $bindParams = [];

    public function __construct(MysqlDb $db)
    {
        $this->db = $db;
        $this->di = DiHelper::getDi();
    }

    /**
     * 模型模式
     * @param bool $isFromModel
     */
    public function setFromModel($isFromModel = true)
    {
        $this->isFromModel = $isFromModel;
        return $this;
    }

    public function getAll()
    {
        return $this->db->fetchAll($this->getSql());
    }

    public function getOne()
    {
        return $this->db->fetchOne($this->getSql());
    }

    public function getDb()
    {
        return $this->db;
    }

    /**
     * select * from table as a join tables as a  on tables.id=table.id  where id=1 order by id desc limit 1,2
     * @return string
     */
    public function getSql()
    {
        return $this->select . ' ' .
            $this->from . ' ' .
            $this->join . ' ' .
            $this->where . ' ' .
            $this->order . ' ' .
            $this->limit;
    }

    /**
     * @param string|array $field
     * 'id,a,model.dd'
     * [
     *  'model.id'=>'mid'
     * ]
     * @return $this
     */
    public function select($field = '*')
    {
        if (is_array($field)) {
            $field = join(',', $field);
        }
        $field = $this->getTrueField($field);
        if ($this->select === null) {
            $this->select = "select $field ";
        } else {
            $this->select .= ",$field";
        }
        return $this;
    }

    /**
     * @param $table string 表名 或者模型名(带命名空间)
     * @param bool $isFromModel
     * @return $this
     */
    public function from($table)
    {
        if (empty($table)) {
            return $this;
        }

        if ($this->from === null) {
            $this->from = 'from ' . $this->getTrueTableName($table);
        } else {
            $this->from .= ' , ' . $this->getTrueTableName($table);
        }
        return $this;
    }

    public function join($table = '', $on = '', $joinType = 'left')
    {
        $allJoinType = ['', 'left', 'right', 'inner'];
        if (!in_array($joinType, $allJoinType)) {
            $joinType = 'left';
        }
        $table = $this->getTrueTableName($table);
        $on = $this->getTrueJoinOn($on);
        if ($this->join === null) {
            $this->join = " $joinType join $table on $on ";
        } else {
            $this->join .= " $joinType join $table on $on ";
        }
        return $this;
    }

    /**
     *  ' a=b and c=9 '
     *  ['like','title' ,'%aaa%']  title like '%aaa%'
     * [
     *      'status' => 10,//`status` = 10)
     * '       type' => null,//(`type` IS NULL)
     * '       id' => [4, 8, 15],//(`id` IN (4, 8, 15))
     *
     * ]
     *
     * @param $where mixed
     * @param $bind array
     * @return  $this
     */
    public function where($where = '', $bindParams = [], $type = 'and')
    {
        $where = $this->getTrueWhere($where);
        if (empty($where)) {
            return $this;
        }
        if ($this->where === null) {
            $this->where = ' where ' . $where;
        } else {
            $allType = ['and', 'or'];
            if (!in_array($type, $allType)) {
                $type = 'and';
            }
            $this->where .= " $type  $where ";
        }
        $this->addBindParams($bindParams);
        return $this;
    }

    public function addBindParams($bindParams = [])
    {
        foreach ($bindParams as $key => $bindParam) {
            $this->addBindParam($key, $bindParam);
        }
    }

    public function addBindParam($key, $bindParam)
    {
        $this->bindParams[$key] = $bindParam;
    }

    public function order($order = '')
    {
        if (empty($order)) {
            return $this;
        }
        $order = $this->getTrueOrder($order);
        if ($this->order === null) {
            $this->order = 'order by ' . $order;
        } else {
            $this->order .= ' , ' . $order;
        }
        return $this;
    }

    public function limit($limit = 0, $offset = null)
    {
        if ($offset === null) {
            $limit = 'limit ' . $limit;
        } else {
            $limit = "limit $offset ,$limit";
        }
        $this->limit = $limit;
        return $this;
    }


    /**
     * 将模型名换成正式表名
     * @param $table
     * @return mixed
     */
    private function getTrueTableName($table)
    {
        $table = trim($table);
        $tables = explode(' as ', $table);
        if ($this->isFromModel && class_exists($tables[0])) {
            $trueTable =  $tables[0];
        } else {
            $trueTable = $tables[0];
        }
        if (count($tables) > 1) {
            return $trueTable . ' as ' . trim($tables[1]);
        } else {
            return $trueTable;
        }
    }

    /**
     * 将字段里的模型名换成真实表名
     * @param string $field
     * @return string
     */
    private function getTrueField($field = '')
    {
        if (empty($field)) {
            return '*';
        }
        $fields = explode(',', $field);
        $returnField = [];
        foreach ($fields as $v) {
            $v = trim($v);
            if (empty($v)) {
                continue;
            }
            if (strpos($v, '.') === false) {
                $returnField[] = $v;
            } else {
                $vs = explode('.', $v);
                $returnField[] = $this->getTrueTableName($vs[0]) . '.' . $vs[1];
            }
        }
        if (empty($returnField)) {
            return '*';
        } else {
            return join(',', $returnField);
        }
    }

    private function getTrueJoinOn($on = '')
    {
        if (empty($on)) {
            return '';
        }
        $allNeedChange = [];
        preg_match_all('/[\w\\\]+\.{1}\w+/i', $on, $allNeedChange);
        if ($allNeedChange) {
            foreach ($allNeedChange[0] as $item) {
                if (empty($item)) {
                    continue;
                }
                $on = str_replace($item, $this->getTrueField($item), $on);
            }
        }
        return $on;
    }

    private function getTrueOrder($order = '')
    {
        if (empty($order)) {
            return '';
        }
        $allNeedChange = [];
        preg_match_all('/[\w\\\]+\.{1}\w+/i', $order, $allNeedChange);
        if ($allNeedChange) {
            foreach ($allNeedChange[0] as $item) {
                if (empty($item)) {
                    continue;
                }
                $order = str_replace($item, $this->getTrueField($item), $order);
            }
        }
        return $order;
    }

    /**
     * where条件中是否包含多个条件
     * @param string $where
     * @return bool
     */
    private function whereIsMuch($where = '')
    {
        $where = strtolower($where);
        if (strpos($where, ' and ') !== false) {
            return true;
        }
        if (strpos($where, ' or ') !== false) {
            return true;
        }
        return false;
    }

    /**
     * @param $where  string|array
     * @return string
     */
    private function getTrueWhere($where)
    {
        if (empty($where)) {
            return '';
        }
        if (is_array($where)) {
            $where = $this->getWhereFromArray($where);
        } else {
            $where = (string)$where;
        }
        if ($this->whereIsMuch($where)) {
            $where = " ($where) ";
        }
        return $where;
    }

    /**
     * @param array $where
     * @return string
     */
    private function getWhereFromArray($where = [])
    {
        $operate = isset($where[0]) ? $where[0] : '';
        if (empty($operate)) {
            return $this->getWhereFromArrayDirect($where);
        } else {
            return $this->getWhereFromArrayOperate($where);
        }
    }

    private function getWhereFromArrayOperate($where)
    {
        $operate = strtolower(trim($where[0]));
        switch ($operate) {
            case 'like':
                return $where[1] . ' like ' . $where[2];
                break;
            case '>':
                return $where[1] . ' > ' . $where[2];
                break;
            case '<':
                return $where[1] . ' > ' . $where[2];
                break;
            default:
                return '';
                break;
        }
    }

    private function getWhereFromArrayDirect($where)
    {
        $res = [];
        foreach ($where as $k => $value) {
            if (is_null($value)) {
                $res[] = "$k IS NULL";
            } elseif (is_array($value)) {
                $res[] = $k . ' IN (' . join(',', $value) . ')';
            } else {
                $value = (string)$value;
                $res[] = "$k=$value";
            }
        }

        return join(' and ', $res);
    }


}