<?php

namespace Common\Models;

class WeStoreFront  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;/*商品id*/
    public $comgoodsid;/*酒店商品id*/
    public $formcode;/*订单ID*/
    public $duid;/*操作人id*/
    public $stimeint;/*操作时间*/
    public $mycount;/*数量*/
    public $mytype;/*入库 from  出库 to*/
    public $other;/*备注信息*/
    public $comid;
    public $store_batch_id;
    public $status;/*1待确认 2 已确认 3 取消*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_store_front';
    }

    /**
     * @param mixed $parameters
     * @return WeStoreFront[]|WeStoreFront|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeStoreFront|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}