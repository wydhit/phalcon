<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-16
 * Time: 7:53
 */

namespace Common\Search;


use Common\Models\WeGroup;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\QueryBuilder;

class GroupSearch extends BaseSearch
{
    public function getGroupForGrid(Request $request)
    {
        $this->searchParamInit($request);
        $builder=$this->builder->from('Common\Models\WeGroup')
            ->where('mytype="group"');

            /*通用处理方式*/
        $builder->orderBy("$this->sidx $this->sord");

        $paginator = (new QueryBuilder([
            "builder" => $builder,
            "limit" => $this->rows,
            "page" => $this->page
        ]))->getPaginate();
        $paginator->items=$paginator->items->filter(function ($data){
            $data->isuse=WeGroup::isuseType($data->isuse);
            return $data;
        });
        /*特殊处理结束*/
        return $this->returnGridData($paginator);        
    }

    public function RoleListForGrid($gid,Request $request)
    {
        $this->searchParamInit($request);
        $builder=$this->builder->from('Common\Models\WeGroup')
            ->where('mytype="role"')
            ->andWhere('pid=:pid:',['pid'=>$gid]);

        $builder->orderBy("$this->sidx $this->sord");
        $paginator = (new QueryBuilder([
            "builder" => $builder,
            "limit" => $this->rows,
            "page" => $this->page
        ]))->getPaginate();

        $paginator->items=$paginator->items->filter(function ($data){
            $data->isuse=WeGroup::isuseType($data->isuse);
            return $data;
        });
        /*通用处理方式*/

        return $this->returnGridData($paginator);
    }
}