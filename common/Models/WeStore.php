<?php

namespace Common\Models;

class WeStore  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;
    public $comgoodsid;/*商家商品id*/
    public $formcode;
    public $duid;
    public $dname;
    public $stime;
    public $stimeint;
    public $mycount;
    public $mytype;
    public $other;
    public $comid;
    public $comic;
    public $comname;
    public $store_batch_id;
    public $batch_num;
    public $indate;/*有效期*/
    public $status;/*1待确认 2 已确认 3 取消*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_store';
    }

    /**
     * @param mixed $parameters
     * @return WeStore[]|WeStore|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeStore|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}