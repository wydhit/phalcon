<?php

namespace Common\Db;


use Common\Helpers\DiHelper;
use Common\Models\BaseModel;
use Common\Models\WeUser;
use Phalcon\Db\Adapter;
use Phalcon\Db;

class Query
{
    public $where;
    public $limit;
    public $offset;
    public $orderBy;
    public $indexBy;
    public $emulateExecution = false;
    public $select;
    public $selectOption;
    public $distinct;
    public $from;
    public $groupBy;
    public $join;
    public $having;
    public $union;
    public $params = [];
    private $db = null;

    public function __construct($config = [], $db)
    {
        foreach ($config as $k => $v) {
            $this->$k = $v;
        }
        if ($db instanceof Adapter) {
            $this->db = $db;
        }
    }

    /**
     * 用法示例 适用于addSelect
     * $query->select(['id', 'email']);
     * $query->select('id, email');
     * $query->select(['user.id AS user_id', 'email']);
     * $query->select('user.id AS user_id, email');
     * $query->select(['user_id' => 'user.id', 'email']);
     * $query->select(["CONCAT(first_name, ' ', last_name) AS full_name", 'email']);
     * @param $columns
     * @return $this
     */
    public function select($columns)
    {
        if (!is_array($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        }
        $this->select = $columns;
        return $this;
    }

    public function addSelect($columns)
    {
        if (!is_array($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        }
        if ($this->select === null) {
            $this->select = $columns;
        } else {
            $this->select = array_merge($this->select, $columns);
        }
        return $this;
    }

    /**
     * 用法示例
     * $query->from('user');
     * $query->from(['public.user u', 'public.post p']);
     * $query->from(['u' => 'public.user', 'p' => 'public.post']);
     * @param $tables
     * @return $this
     */
    public function from($tables)
    {
        if (!is_array($tables)) {
            $tables = preg_split('/\s*,\s*/', trim($tables), -1, PREG_SPLIT_NO_EMPTY);
        }
        $this->from = $tables;
        return $this;
    }



    /**
     * 查询条件
     * $query->where('status=1');
     * $query->where('status=:status', [':status' => $status]);
     * $query->where([
     *      'status' => 10,
     *      'type' => null,
     *      'id' => [4, 8, 15],
     *      ]);
     * 上面的数组where将转为
     * WHERE (`status` = 10) AND (`type` IS NULL) AND (`id` IN (4, 8, 15))
     * $query->where(['and', 'id=1', 'id=2']) 将会生成 id=1 AND id=2
     * $query->where(['or', 'id=1', 'id=2']) 将会生成 id=1 or id=2
     * $query->where(['between', 'id', 1, 10]) 将会生成 id BETWEEN 1 AND 10
     * $query->where(['not between', 'id', 1, 10]) 将会生成 id not between 1 AND 10
     * $query->where(['in', 'id', [1, 2, 3]]) 将会生成 id IN (1, 2, 3)
     * $query->where(['not in', 'id', [1, 2, 3]]) 将会生成 not in IN (1, 2, 3)
     * $query->where(['like', 'name', 'tester']) 将会生成 name LIKE '%tester%'
     * $query->where(['like', 'name', ['test', 'sample']] ) 将会生成 name LIKE '%test%' AND name LIKE '%sample%'
     * $query->where(['>', 'age', 10]] ) 将会生成 age >10
     * @param $condition
     * @param array $params
     * @return $this
     */
    public function where($condition, $params = [])
    {
        $this->where = $condition;
        $this->addParams($params);
        return $this;
    }

    public function andWhere($condition, $params = [])
    {
        if ($this->where === null) {
            $this->where = $condition;
        } elseif (is_array($this->where) && isset($this->where[0]) && strcasecmp($this->where[0], 'and') === 0) {
            $this->where[] = $condition;
        } else {
            $this->where = ['and', $this->where, $condition];
        }
        $this->addParams($params);
        return $this;
    }

    public function orWhere($condition, $params = [])
    {
        if ($this->where === null) {
            $this->where = $condition;
        } else {
            $this->where = ['or', $this->where, $condition];
        }
        $this->addParams($params);
        return $this;
    }

    /**
     * $query->where('status=:status')->addParams([':status' => $status]);
     * 增加参数绑定
     * @param $params
     * @return $this
     */
    public function addParams($params)
    {
        if (!empty($params)) {
            if (empty($this->params)) {
                $this->params = $params;
            } else {
                foreach ($params as $name => $value) {
                    if (is_int($name)) {
                        $this->params[] = $value;
                    } else {
                        $this->params[$name] = $value;
                    }
                }
            }
        }
        return $this;
    }

    /**
     *
     * $query->orderBy([
     *      'id' => SORT_ASC,
     *      'name' => SORT_DESC,
     *      ]);
     * ORDER BY `id` ASC, `name` DESC
     * @param $columns
     * @return $this
     */
    public function orderBy($columns)
    {
        $this->orderBy = $this->normalizeOrderBy($columns);
        return $this;
    }

    public function addOrderBy($columns)
    {
        $columns = $this->normalizeOrderBy($columns);
        if ($this->orderBy === null) {
            $this->orderBy = $columns;
        } else {
            $this->orderBy = array_merge($this->orderBy, $columns);
        }
        return $this;
    }

    /**
     * $query->groupBy(['id', 'status']); GROUP BY `id`, `status`
     * @param $columns
     * @return $this
     */
    public function groupBy($columns)
    {
        if (!is_array($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        }
        $this->groupBy = $columns;
        return $this;
    }

    public function addGroupBy($columns)
    {
        if (!is_array($columns)) {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
        }
        if ($this->groupBy === null) {
            $this->groupBy = $columns;
        } else {
            $this->groupBy = array_merge($this->groupBy, $columns);
        }
        return $this;
    }

    public function limit($limit)
    {
        $this->limit = $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = $offset;
        return $this;
    }

    /**
     * $query->join('LEFT JOIN', 'post', 'post.user_id = user.id');  LEFT JOIN `post` ON `post`.`user_id` = `user`.`id`
     * @param $type  string 连接类型，例如：'INNER JOIN', 'LEFT JOIN'。
     * @param $table string 将要连接的表名称。
     * @param string $on 连接条件
     * @param array $params 可选参数，与连接条件绑定的参数
     * @return Query
     */
    public function join($type, $table, $on = '', $params = [])
    {
        $this->join[] = [$type, $table, $on];
        return $this->addParams($params);
    }

    public function rightJoin($table, $on = '', $params = [])
    {
        $this->join[] = ['RIGHT JOIN', $table, $on];
        return $this->addParams($params);
    }

    public function leftJoin($table, $on = '', $params = [])
    {
        $this->join[] = ['LEFT JOIN', $table, $on];
        return $this->addParams($params);
    }

    public function innerJoin($table, $on = '', $params = [])
    {
        $this->join[] = ['INNER JOIN', $table, $on];
        return $this->addParams($params);
    }



    protected function normalizeOrderBy($columns)
    {
        if (is_array($columns)) {
            return $columns;
        } else {
            $columns = preg_split('/\s*,\s*/', trim($columns), -1, PREG_SPLIT_NO_EMPTY);
            $result = [];
            foreach ($columns as $column) {
                if (preg_match('/^(.*?)\s+(asc|desc)$/i', $column, $matches)) {
                    $result[$matches[1]] = strcasecmp($matches[2], 'desc') ? SORT_ASC : SORT_DESC;
                } else {
                    $result[$column] = SORT_ASC;
                }
            }
            return $result;
        }
    }








    /**
     * @return QueryBuilder
     */
    public function getQueryBuilder()
    {
        return (new QueryBuilder());
    }

    private function getDb($db = null)
    {
        if ($db === null) {
            $db = $this->db;
        }
        if ($db === null) {
            $db = DiHelper::getDi()->get('db');
        }
        if (!$db instanceof Adapter) {
            throw new \LogicException('没找到数据库服务');
        }
        return $db;
    }


}