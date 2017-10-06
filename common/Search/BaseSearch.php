<?php

namespace Common\Search;

use Common\Core\BaseInjectable;
use Common\Helpers\DiHelper;
use Phalcon\Http\Request;
use Phalcon\Mvc\Model\Query\BuilderInterface;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * 0、初始化搜索条件，并做一些安全性处理  有 searchData 优先从 searchData中获取搜索条件 没有 searchData 从所有_GET中获取搜索条件
 * 1、构建builder
 * 2、根据builder 获取所有筛选数据
 * 3、根据builder 获取分页数据
 *
 * Class BaseSearch
 * @package Common\Search
 */
class BaseSearch extends BaseInjectable
{
    public $page = 1;/*第几页*/
    public $rows = 20;/*一个几条数据*/
    public $sidx = 'id';/*排序字段*/
    public $sord = 'desc';/*排序方式*/
    public $searchData = [];/*搜索条件及返回其他附属数据*/
    /**
     * @var $builder BuilderInterface
     */
    public $builder;
    private $paginateCache = [];

    public function __construct()
    {
        $this->searchParamInit($this->request);/*初始化搜索条件*/
        $this->builder = $this->modelsManager->createBuilder();
        $this->initialize();
    }

    public function initialize()
    {
    }

    public function order($order = null)
    {
        if ($order===null) {
            $order=$this->sidx.' '.$this->sord;
        }
        if($order!==''){
            $this->builder->orderBy($order);
        }
        return $this;
    }

    /**
     * @param null|Request $request
     */
    public function searchParamInit($request = null)
    {
        if ($request === null) {
            $request = DiHelper::getRequest();
        }
        $this->page = (int)$request->get('page', 'int', 1);
        $this->rows = (int)$request->get('rows', 'int', 20);
        $this->sidx = $request->get('sidx', 'string', 'id');
        $this->sord = $request->get('sord', 'string', 'desc');
        $this->searchData = $request->get('searchData', null, []);
        if (empty($this->searchData)) {
            foreach ($request->getQuery() as $k => $v) {
                $this->searchData[$k] = $v;
            }
        }
        /*进一步处理搜索条件*/
        if (!empty($this->searchData) && is_array($this->searchData)) {
            foreach ($this->searchData as $k => $data) {
                $data = trim($data);
                if (is_string($data) && $data === '') {
                    $data = null;
                }
                $data = htmlspecialchars($data);
                $this->searchData[$k] = $data;
            }
        }


    }

    public function getSearchAllData()
    {
        return $this->searchData;
    }

    public function getSearchData($field = '', $default = '')
    {
        if (isset($this->searchData[$field])) {
            return $this->searchData[$field];
        } else {
            return $default;
        }
    }

    /**
     * @param $builder  \Phalcon\Mvc\Model\Query\BuilderInterface
     * @return \stdClass
     */
    public function getPaginator($builder = null)
    {
        if ($builder === null) {
            $builder = $this->builder;
        }
        $builderHash = md5(json_encode($builder));
        if (isset($this->paginateCache[$builderHash])) {
            return $this->paginateCache[$builderHash];
        } else {
            return $this->paginateCache[$builderHash] = (new QueryBuilder([
                "builder" => $builder,
                "limit" => $this->rows,
                "page" => $this->page
            ]))->getPaginate();
        }
    }

    /**
     * 不分页处理返回所有数据
     * @param null $filter
     * @return mixed
     */
    public function returnAllData($filter = null)
    {
        $data = $this->builder->getQuery()->execute();
        if ($filter !== null && is_callable($filter) && method_exists($data, 'filter')) {
            $data = $data->filter($filter);
        }
        return $data;
    }

    public function returnOneData()
    {
        return $this->builder->getQuery()->setUniqueRow(true)->execute();
    }

    /**
     * 不分页数据 直接返回response
     * @param $filter
     * @return \Phalcon\Http\Response
     */
    public function returnAllResponse($filter)
    {
        $response = DiHelper::getResponse();
        $response->setHeader('Content-type', 'application/json');
        $response->setJsonContent($this->returnAllData($filter));
        return $response;
    }

    /**
     * 返回分页数据 一般给视图table输出数据用
     * @param null $filter
     * @param array $searchData
     * @return array
     */
    public function returnPaginatorData($filter = null, $searchData = [])
    {
        $paginator = $this->getPaginator();
        return $this->handlePaginatorData($paginator, $filter, $searchData);
    }

    /**
     *返回分页响应response 一般给jqgrid用
     */
    public function returnPaginatorResponse($filter = null, $searchData = [])
    {
        $response = DiHelper::getResponse();
        $response->setHeader('Content-type', 'application/json');
        $response->setJsonContent($this->returnPaginatorData($filter, $searchData));
        return $response;
    }

    /**
     * 处理数据
     * @param $paginator
     * @param null $filter
     * @param array $searchData
     * @return array
     */
    private function handlePaginatorData($paginator, $filter = null, $searchData = [])
    {
        /*还是原始的Result结果集并有过滤函数传递进来*/
        if ($filter !== null && is_callable($filter) && method_exists($paginator->items, 'filter')) {
            $data = $paginator->items->filter($filter);
        } elseif (method_exists($paginator->items, 'toArray')) {/*没有传递进来处理函数，还是Result结果集处理成数组*/
            $data = $paginator->items->toArray();
        } else {
            $data = $paginator->items;/*在外部已经处理成数组了*/
        }
        $returnArray = [];
        /*当前页记录数据*/
        $returnArray['rows'] = is_array($data) ? $data : (array)$data;
        /*总共多少条数据*/
        $returnArray['records'] = $paginator->total_items;
        /*当前第几页数据*/
        $returnArray['page'] = $paginator->current;
        /*总共多少页数据*/
        $returnArray['total'] = $paginator->total_pages;
        $returnArray['limit'] = $paginator->limit;
        $returnArray['status'] = 'success';/*状态成功*/
        $returnArray['searchData'] = array_merge($this->searchData, $searchData);
        return $returnArray;
    }

}