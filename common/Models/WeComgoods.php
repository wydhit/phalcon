<?php

namespace Common\Models;

class WeComgoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;/*商品id*/
    public $goodsic;/*商品ic 商品ic应在商品表中统一记录，此处应逐渐抛弃不用*/
    public $price;/*价格*/
    public $commission;/*神灯佣金*/
    public $comid;/*店铺ic*/
    public $inventories;/*库存量总库存*/
    public $inventoriesalarm;/*库存量警戒值*/
    public $supply_price;/*供货价*/
    public $sale_price;/*店内有售价格*/
    public $sale_commission;/*店内佣金*/
    public $isdel;/*是否删除*/
    public $inventories_store;/*库房库存*/
    public $inventories_front;/*前台库存*/
    public $inventories_sd;/*神灯库存*/
    public $cls;/*排序*/
    public $status;/*1 正常状态，2待审核*/
    public $type;/*1垫付，2自采*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_comgoods';
    }

    /**
     * @param mixed $parameters
     * @return WeComgoods[]|WeComgoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeComgoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}