<?php

namespace Common\Models;

class WeOrderPay  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $allprice;/*订单总额*/
    public $yue_price;/*余额支付金额*/
    public $zengkuan_price;/*赠款支付金额*/
    public $coupon_price;/*优惠劵金额*/
    public $other_price;/*第三方支付金额= allprice-yue_price-zengkuan_price*/
    public $service_price;/*服务费-店内售卖人员送货产生的费用*/
    public $payway;/*支付方式*/
    public $stime;/*创建时间*/
    public $stimeint;/*创建时间*/
    public $ispayed;/*是否支付0未支付；1已支付*/
    public $stime_pay;/*支付时间*/
    public $pay_code;/*支付单号-系统自动生成非重复码*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_order_pay';
    }

    /**
     * @param mixed $parameters
     * @return WeOrderPay[]|WeOrderPay|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrderPay|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}