<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-13
 * Time: 17:03
 */

namespace Bizer\Search;


use Common\Helpers\NumberHelper;
use Common\Models\WeCom;
use Common\Search\BaseComSearch;
use Common\Services\ComService;

class ComSearch extends BaseComSearch
{
    public function comListBySysBizer($sysBizerId = 0)
    {
        $this->builder->from(['com' => WeCom::class])
            ->columns([
                'com.id',
                'com.ic',
                'com.isrun',
                'com.islock',
                'com.title',
            ]);
        $this->searchBizerId($sysBizerId);
        $this->searchTitle();
        $this->order();
        $startTime=$this->getSearchData('startTime');
        $endTime=$this->getSearchData('endTime');
        $orderType=$this->getSearchData('$orderType');
        return $this->returnPaginatorResponse(function ($data)use($startTime,$endTime,$orderType) {
            $saleData=OrderSearch::instance()->comSale($data->id,$startTime,$endTime,$orderType);
            $data->isrunTips = WeCom::getRunTips($data->isrun);
            $data->islockTips = WeCom::getLockTips($data->islock);
            $data->allprice =NumberHelper::renderMoney($saleData['allprice']);
            $data->commission =NumberHelper::renderMoney($saleData['commission']);
            return $data;
        });
    }

}