<?php

namespace Common\Models;

class WeOrdergoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $orderid;
    public $title;
    public $price;
    public $allprice;
    public $goodsid;
    public $comgoodsid;
    public $comid;
    public $preimg;
    public $placeid;
    public $deviceid;
    public $doorid;
    public $mystatus;
    public $counts;
    public $doortitle;
    public $door_num;/*房间号-店内有售录入*/
    public $order_type;/*订单类型：0表示格子机销售1表示店内销售*/
    public $act_goodsid;
    public $commission;/*单价佣金*/
    public $couponIds;/*使用优惠劵id*/
    public $couponPrice;/*优惠劵顶替金额*/
    public $couponInfo;/*每个优惠劵抵了多少钱*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_ordergoods';
    }

    /**
     * @param mixed $parameters
     * @return WeOrdergoods[]|WeOrdergoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrdergoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}