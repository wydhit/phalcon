<?php

namespace Common\Models;

class WeChangeBatch  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comid;/*商家id*/
    public $old_goodsid;/*原来的商品id*/
    public $old_goodstitle;/*原来的商品名称*/
    public $old_goodsisgroup;/*是否组合品*/
    public $old_goods_mygroup;/*组合品信息*/
    public $new_goodsid;/*新商品id*/
    public $new_goodstitle;/*新商品名称*/
    public $new_goodsisgroup;/*是否组合品*/
    public $new_goods_mygroup;/*组合品信息*/
    public $duid;/*操作者id*/
    public $stimeint;/*操作时间*/
    public $change_door_num;/*替换了几个门*/
    public $hasgoods_door_num;/*替换时有货的几个门*/
    public $nogoods_door_num;/*替换时没货的几个门*/
    public $change_info;/*操作更换的柜门信息 json数据保存*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_change_batch';
    }

    /**
     * @param mixed $parameters
     * @return WeChangeBatch[]|WeChangeBatch|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeChangeBatch|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}