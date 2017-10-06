<?php

namespace Common\Models;

class WeComReplenishVmomey  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $comid;/*店铺id*/
    public $take_replenish_vmomey;/*take_replenish_vmomey*/
    public $money_precent;/*给补货员红包用 给钱的百分比 30 代表30%*/
    public $min_money;/*给补货员红包用  至少给多少钱 1代表一分 0.01元*/
    public $max_limit_time;/*给补货员红包用 超过7天的订单不再给红包*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_com_replenish_vmomey';
    }

    /**
     * @param mixed $parameters
     * @return WeComReplenishVmomey[]|WeComReplenishVmomey|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeComReplenishVmomey|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}