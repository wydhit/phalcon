<?php

namespace Common\Models;

class WeGoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;/*商品名称*/
    public $preimg;/*商品图片*/
    public $bigimg;/*大图片*/
    public $content;/*商品内容*/
    public $readme;
    public $comid;/*店铺id代表是店铺添加的商品*/
    public $isgroup;
    public $mygroup;
    public $inventories;/*平台库存量*/
    public $inventoriessum;/*总库存量*/
    public $inventoriesalarm;/*警戒库存*/
    public $salenum;
    public $base_price;/*厂批价*/
    public $sysbizer_id;/*代表是商家用户商品*/
    public $isdel;/*是否删除*/
    public $class_id;/*class表外键*/
    public $comClass_id;/*comClassify表外键*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_goods';
    }

    /**
     * @param mixed $parameters
     * @return WeGoods[]|WeGoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeGoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}