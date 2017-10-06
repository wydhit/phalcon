<?php

namespace Common\Models;

class WeCheckcontent  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $checkid;
    public $xh;/*序号*/
    public $goodsid;/*商品id*/
    public $allprice;/*成交价格*/
    public $commission;/*利润或供货价，存为正值*/
    public $ordernum;/*订单成交数*/
    public $goodsnum;/*商品成交数*/
    public $allcommission;/*本次利润或供货价，存为正值*/
    public $orderlist;/*成交订单号*/
    public $title;/*商品名称*/
    public $mytype;/*平台对账pingtai、自销对账zixiao*/
    public $check_type;/*对账单对应订单类型：1神灯订单2店内有售3是自销*/
    public $comgoodsid;/*酒店商品ID*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_checkcontent';
    }

    /**
     * @param mixed $parameters
     * @return WeCheckcontent[]|WeCheckcontent|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCheckcontent|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}