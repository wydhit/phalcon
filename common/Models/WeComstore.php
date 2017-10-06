<?php

namespace Common\Models;

class WeComstore  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;/*商品id*/
    public $comgoodsid;/*酒店商品id*/
    public $formcode;
    public $duid;
    public $dname;
    public $stime;/*时间*/
    public $stimeint;/*时间*/
    public $mycount;
    public $mytype;
    public $other;
    public $comid;/*店铺id*/
    public $comic;/*店铺ic*/
    public $comname;/*店铺名称*/
    public $store_batch_id;
    public $batch_num;/*商品批号*/
    public $indate;
    public $status;/*1待确认 2 已确认 3 取消*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_comstore';
    }

    /**
     * @param mixed $parameters
     * @return WeComstore[]|WeComstore|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeComstore|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}