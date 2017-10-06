<?php

namespace Common\Models;

class WeCounts  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $mytype;/*类型*/
    public $hitid;/*访问的id号*/
    public $stimeint;/*submit time*/
    public $myip;
    public $doorid;
    public $comid;
    public $placeid;
    public $deviceid;
    public $orderid;
    public $uid;
    public $goodsid;
    public $comgoodsid;
    public $price;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_counts';
    }

    /**
     * @param mixed $parameters
     * @return WeCounts[]|WeCounts|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCounts|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}