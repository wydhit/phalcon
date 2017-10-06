<?php

namespace Common\Models;

class WeCouponDetail  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $couponId;
    public $code;
    public $userId;/*被谁领取了*/
    public $getTime;/*领取时间*/
    public $isUsed;/*是不是使用了*/
    public $useTime;/*使用时间*/
    public $takeMoney;/*实际抵消金额 单位分*/
    public $ActivityIc;/*通过活动获取的记录下活动标示*/
    public $couponPic;
    public $buyUrl;
    public $tips;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_coupon_detail';
    }

    /**
     * @param mixed $parameters
     * @return WeCouponDetail[]|WeCouponDetail|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCouponDetail|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}