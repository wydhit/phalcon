<?php

namespace Common\Models;

class WeCoupon  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $title;/*分类id*/
    public $useBeginTime;/*开始使用时间 一般是生成时间*/
    public $useEndTime;/*失效时间*/
    public $doUserId;/*谁生成的优惠劵*/
    public $doTime;/*生成时间*/
    public $useType;/*1=>'满减',2=>'打折'*/
    public $money;/*面值 单位分*/
    public $discount;/*折扣1-100  单位%*/
    public $useOtherNum;/* 使用这个优惠劵还可以使用其他优惠劵数量*/
    public $goodsid;
    public $comgoodsid;/*只能对针对这个商品使用优惠劵*/
    public $useMinMoney;/*高于这个价值的商品才能使用优惠劵 单位分*/
    public $comids;/*只能在这些店铺内使用*/
    public $maxNum;/*最多可以领取几张*/
    public $comTake;/*店铺费用承担比例0-100*/
    public $status;/*0不可用 1可用*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_coupon';
    }

    /**
     * @param mixed $parameters
     * @return WeCoupon[]|WeCoupon|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCoupon|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}