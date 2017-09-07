<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-27
 * Time: 14:44
 */

namespace Common\Search;


use Common\Core\BaseInjectable;
use Common\Helpers\DiHelper;
use Common\Helpers\StringHelper;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\QueryBuilder;

/**
 * 搜索类必须有明确的搜索条件（搜索参数）和搜索结果（需要哪些字段）
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
    public function initialize()
    {
        $this->searchParamInit($this->request);/*初始化搜索条件*/
        parent::initialize();
    }
    /**
     * @param null|Request $request
     */
    public function searchParamInit($request = null)
    {
        if ($request === null) {
            $request = DiHelper::getDi()->get('request');
        }
        $this->page = (int)$request->get('page', 'int', 1);
        $this->rows = (int)$request->get('rows', 'int', 20);
        $this->sidx = $request->get('sidx', 'string', 'id');
        $this->sord = $request->get('sord', 'string', 'desc');
        $this->searchData = $request->get('searchData', null, []);
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

    /**
     * @param $builder  \Phalcon\Mvc\Model\Query\BuilderInterface
     * @return \stdClass
     */
    public function getPaginator($builder)
    {
        return (new QueryBuilder([
            "builder" => $builder,
            "limit" => $this->rows,
            "page" => $this->page
        ]))->getPaginate();
    }

    /**
     *返回数据Array结果
     * @param $paginator
     * @param null $filter
     * @param array $searchData
     * @return array
     */
    public function returnData($paginator, $filter = null, $searchData = [])
    {
        return $this->handleData($paginator, $filter, $searchData);
    }

    /**
     * 给DataGrid用 直接返回Response对象，视图里直接返回这个返回值即可
     * @param $paginator
     * @param null $filter
     * @param array $searchData
     * @return mixed
     */
    public function returnJson($paginator, $filter = null, $searchData = [])
    {
        $data = $this->handleData($paginator, $filter, $searchData);
        if (method_exists($this, 'getResponse')) {
            $response = $this->getResponse();
        } else {
            $response = DiHelper::getDi()->get('response');
        }
        $response->setHeader('Content-type', 'application/json');
        $response->setJsonContent($data);
        return $response;
    }

    public function handleData($paginator, $filter = null, $searchData = [])
    {
        /*还是原始的Result结果集并有过滤函数传递进来*/
        if ($filter !== null && is_callable($filter) && method_exists($paginator->items, 'filter')) {
            $data = $paginator->items->filter($filter);
        } elseif (method_exists($paginator->items, 'toArray')) {/*没有传递进来处理函数，还是Result结果集处理成数组*/
            $data = $paginator->items->toArray();
        } else {
            $data = $paginator->items;/*在外部已经处理成数组了*/
        }
       // StringHelper::dd($paginator);
        $returnArray = [];
        /*当前页记录数据*/
        $returnArray['rows'] = is_array($data) ? $data : (array)$data;
        /*总共多少条数据*/
        $returnArray['records'] = $paginator->total_items;
        /*当前第几页数据*/
        $returnArray['page'] = $paginator->current;
        /*总共多少页数据*/
        $returnArray['total'] = $paginator->total_pages;
        $returnArray['status'] = 'success';/*状态成功*/
        $returnArray['searchData'] = array_merge($this->searchData, $searchData);
        return $returnArray;
    }
}