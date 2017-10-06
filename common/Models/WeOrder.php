<?php

namespace Common\Models;

class WeOrder  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $pay_code;/*支付单号-系统自动生成非重复码*/
    public $allprice;/*订单总额*/
    public $yue_price;/*余额支付金额，已转移到Order_pay中记录*/
    public $zengkuan_price;/*赠款支付金额 已转移到Order_pay中记录*/
    public $other_price;/*第三方支付金额 已转移到Order_pay中记录*/
    public $service_price;/*服务费-店内售卖人员送货产生的费用*/
    public $coupon_price;/*优惠劵金额*/
    public $commission;/*返佣*/
    public $stime;
    public $stimeint;
    public $uid;
    public $ispayed;/*是否支付*/
    public $mystatus;/*是否打开柜门取货*/
    public $gids;/*商品id*/
    public $payway;/*付款方式*/
    public $comid;/*酒店id*/
    public $placeid;/*地点id*/
    public $mytype;/*定单类型，临时定单还是正式定单*/
    public $doorids;/*门号*/
    public $deviceid;/*设备id*/
    public $comgoodsids;/*酒店商品id*/
    public $doorstatus;/*门状态*/
    public $mygoods;/*定单商品列表*/
    public $paytimeint;/*支付时间*/
    public $alllocker;/*所有门锁*/
    public $goodlocker;/*已打开的门锁*/
    public $badlocker;/*未打开的门锁*/
    public $order_type;/*订单类型：0表示格子机销售1表示店内销售*/
    public $door_num;/*房间号-店内有售录入*/
    public $floor;/*楼层*/
    public $isdel;/*是否删除*/
    public $des;/*保存备注信息*/
    public $act_id;
    public $act_goodsid;
    public $accept_goods_code;/*收货验证码*/
    public $isexpress;/*1为快递订单 0 普通订单*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_order';
    }

    /**
     * @param mixed $parameters
     * @return WeOrder[]|WeOrder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getOrderStatusTips($orderStatus='')
    {
        if($orderStatus=='payed'){
            return '已支付';
        }elseif($orderStatus==='taken'){
            return '已完成';
        }else{
            return '';
        }

    }


}