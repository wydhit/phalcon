<?php

namespace Common\Models;

class WeMarketingActivityGoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $act_id;
    public $goodsid;/*商品id*/
    public $supply_price;/*供货价*/
    public $sale_price;/*售价*/
    public $sale_commission;/*佣金*/
    public $sale_cnt;/*出售最高限额，null是无限额*/
    public $cls;/*排序*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_marketing_activity_goods';
    }

    /**
     * @param mixed $parameters
     * @return WeMarketingActivityGoods[]|WeMarketingActivityGoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMarketingActivityGoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}