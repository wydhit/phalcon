<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-27
 * Time: 10:57
 */

namespace Common\Search;


use Common\Exception\LogicException;
use Common\Exception\SearchFailException;
use Common\Helpers\ArrayHelper;
use Common\Helpers\NumberHelper;
use Common\Helpers\StringHelper;
use Common\Helpers\TimeHelper;
use Common\Models\WeCom;
use Common\Models\WeComgoods;
use Common\Models\WeOrder;
use Common\Traits\SearchForGrid;
use Phalcon\Http\Request;
use Phalcon\Paginator\Adapter\QueryBuilder;
use Phalcon\Tag;

class BaseComSearch extends BaseSearch
{

    /*//
    //    public function index($bizerId = 0)
    //    {
    //       //*搜索处理区
    //        $this->builder->from(['com' => WeCom::class])
    //            ->columns([
    //                'com.*',
    //                'com.id'
    //            ]);
    //        //->leftJoin(WeOrder::class, "com.id=orders.comid", 'orders');
    //        $this->searchTitle()->searchBizerId($bizerId);
    //
    //        $this->order("com.$this->sidx $this->sord");   //*处理排序
    //        $paginator = $this->getPaginator($this->builder);//*构建分页
    //
    //        //*其他附属数据处理
    //        $moneyTotal = NumberHelper::renderMoney(ArrayHelper::moreArraySum($paginator->items->toArray(), 'id'));
    //
    //        //*进一步处理返回需要的数据
    //        return $this->returnData($paginator, function ($result) {
    //            $result->com->preimgStr = Tag::image($result->com->preimg);
    //            return $result;
    //        }, ['money_total' => $moneyTotal]);
    //    }*/

    public function searchTitle($title = '')
    {
        $title = empty($title) ? $this->getSearchData('title') : $title;
        if (strlen($title) > 200) {
            throw new SearchFailException('店铺名称过长');
        }
        if (!empty($title)) {
            $this->builder->andWhere('com.title like :title:', ['title' => "%{$title}%"]);
        }
        return $this;
    }

    public function searchBizerId($bizerId = 0)
    {
        $this->builder->andWhere('com.uid=:uid: ', ['uid' => $bizerId]);
        return $this;
    }


}