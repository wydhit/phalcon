<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-14
 * Time: 9:07
 */

namespace Bizer\Search;


use Common\Helpers\StringHelper;
use Common\Helpers\TimeHelper;
use Common\Models\WeCom;
use Common\Models\WeOrder;
use Common\Models\WePlace;
use Common\Search\BaseOrderSearch;

class OrderSearch extends BaseOrderSearch
{
    public function sdOrderList($sysBizerId=0)
    {
        if(empty($sysBizerId)){
            return [];
        }
        $this->builder->from(['orders'=>WeOrder::class])
            ->leftJoin(WePlace::class,'place.id=orders.placeid','place')
            ->leftJoin(WeCom::class,'com.id=orders.comid','com')
            ->columns([
                'orders.id',
                'orders.allprice',
                'orders.service_price',
                'orders.commission',
                'orders.uid',
                'orders.ispayed',
                'orders.mystatus',
                'orders.payway',
                'orders.placeid',
                'orders.badlocker',
                'orders.goodlocker',
                'orders.alllocker',
                'orders.stimeint',
                'orders.stime',
                'orders.comid',
                'orders.mygoods',
                'placeTitle'=>'place.title',
                'building'=>'place.building',
                'floor'=>'place.floor',
                'comTitle'=>'com.title'
            ]);
        $this->sysBizerOrder($sysBizerId);
        $this->orderNoDel();/*未删除*/
        $this->orderIsPayed();/*已支付*/
        $this->isSdOrder();/*神灯订单*/
        $this->startTime();/*开始时间*/
        $this->endTime();/*截止时间*/
        $this->orderStatus();/*订单状态*/
        $this->doorStatus();/*柜门状态*/
        $this->goodTitle($this->getSearchData('goodTitle'),0,$sysBizerId);/*商品名称*/
        $this->place();
        $this->order('orders.id desc');
        return $this->builder;
    }

    public function dnOrderList($sysBizerId=0)
    {
        if(empty($sysBizerId)){
            return [];
        }
        $this->builder->from(['orders'=>WeOrder::class])
            ->leftJoin(WePlace::class,'place.id=orders.placeid','place')
            ->leftJoin(WeCom::class,'com.id=orders.comid','com')
            ->columns([
                'orders.id',
                'orders.allprice',
                'orders.service_price',
                'orders.commission',
                'orders.uid',
                'orders.ispayed',
                'orders.mystatus',
                'orders.payway',
                'orders.placeid',
                'orders.badlocker',
                'orders.goodlocker',
                'orders.alllocker',
                'orders.stimeint',
                'orders.stime',
                'orders.comid',
                'orders.mygoods',
                'placeTitle'=>'place.title',
                'building'=>'place.building',
                'floor'=>'place.floor',
                'comTitle'=>'com.title'
            ]);
        $this->sysBizerOrder($sysBizerId);
        $this->orderNoDel();/*未删除*/
        $this->orderIsPayed();/*已支付*/
        $this->isSdOrder();/*神灯订单*/
        $this->startTime();/*开始时间*/
        $this->endTime();/*截止时间*/
        $this->orderStatus();/*订单状态*/
        $this->doorStatus();/*柜门状态*/
        $this->goodTitle($this->getSearchData('goodTitle'),0,$sysBizerId);/*商品名称*/
        $this->place();
        $this->order('orders.id desc');
        return $this->builder;
    }

    public function sumTotal()
    {
        $this->builder->columns([
            'allprice'=>'sum(orders.allprice)',
            'commission'=>'sum(orders.commission)',
        ]);
        return $this->returnOneData();
    }

    /**
     * 店铺销售情况统计 统计某个店铺一段时间内，某个订单类型销售数据
     * @param $comid
     * @param string $startTime
     * @param string $endTime
     * @param null $orderType
     * @return mixed
     */
    public function comSale($comid,$startTime='',$endTime='',$orderType=null)
    {
        $this->builder->from(['orders'=>WeOrder::class])
            ->columns([
                "allprice"=>'sum(allprice)',
                "commission"=>'sum(allprice)'
            ])
            ->andWhere('comid=:comid:',['comid'=>$comid]);
        $startTime=TimeHelper::getStartTime($startTime,-600);
        $this->builder->andWhere("stimeint > $startTime");
        $endTime=TimeHelper::getEndTime($endTime);
        $this->builder->andWhere("stimeint < $endTime");
        $this->orderType($orderType);
        return $this->returnOneData();
    }



}