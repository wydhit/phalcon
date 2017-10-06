<?php

namespace Common\Models;

class WeFrontSellOrderDetail  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*ID*/
    public $order_id;/*订单编号*/
    public $goodsid;/*商品ID*/
    public $comgoodsid;/*商品ID（酒店内部）*/
    public $sell_count;/*销售数量*/
    public $sell_price;/*销售价格（单位：分）*/
    public $sell_money;/*销售金额（单位：分）*/
    public $supply_price;/*供货价（单位：分）*/
    public $supply_money;/*供货总成本（单位：分）*/
    public $commission;/*单位返佣（单位：分）*/
    public $commission_total;/*合计返佣（单位：分）*/
    public $create_time;/*创建时间*/
    public $comgoods_type;/*1垫付，2自采*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_front_sell_order_detail';
    }

    /**
     * @param mixed $parameters
     * @return WeFrontSellOrderDetail[]|WeFrontSellOrderDetail|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeFrontSellOrderDetail|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}