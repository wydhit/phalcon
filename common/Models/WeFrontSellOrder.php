<?php

namespace Common\Models;

class WeFrontSellOrder  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*ID*/
    public $uid;/*操作人ID*/
    public $comid;/*酒店ID*/
    public $order_money;/*订单金额（单位：分）*/
    public $supply_money;/*供货价格*/
    public $order_notes;/*订单备注*/
    public $sell_detail;/*商品明细*/
    public $create_time;/*创建时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_front_sell_order';
    }

    /**
     * @param mixed $parameters
     * @return WeFrontSellOrder[]|WeFrontSellOrder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeFrontSellOrder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}