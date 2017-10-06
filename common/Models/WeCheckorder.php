<?php

namespace Common\Models;

class WeCheckorder  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $checkcontentid;
    public $orderid;/*订单id*/
    public $title;/*商品名称*/
    public $duid;/*操作人id*/
    public $dnick;/*操作人*/
    public $allprice;/*成交价格*/
    public $commission;/*利润*/
    public $stime;/*操作时间*/
    public $myfromname;/*订单类型*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_checkorder';
    }

    /**
     * @param mixed $parameters
     * @return WeCheckorder[]|WeCheckorder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCheckorder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}