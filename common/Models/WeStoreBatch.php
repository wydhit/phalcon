<?php

namespace Common\Models;

class WeStoreBatch  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comid;/*商家id*/
    public $stimeint;/*发货时间*/
    public $formcode;/*发货凭证号*/
    public $duid;/*发货人id*/
    public $status;/*1发货待确认，2确认收货,3取消收货*/
    public $ruid;/*接收人id*/
    public $rtimeint;
    public $isdel;
    public $other;/*备注信息*/
    public $storefrom;/*1平台2商家库房3前台库4神灯5客户*/
    public $storeto;/*1平台2商家库房3前台库4神灯5客户*/
    public $type_count;/*商品种类数量*/
    public $storefrom_front_cnt;/*出库库房出库前数量*/
    public $storeto_front_cnt;/*入库库房入库前数量*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_store_batch';
    }

    /**
     * @param mixed $parameters
     * @return WeStoreBatch[]|WeStoreBatch|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeStoreBatch|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}