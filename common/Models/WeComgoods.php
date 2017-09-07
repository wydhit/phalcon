<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeComgoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;/*商品id*/
    public $comid;/*店铺id*/
    public $price;/*销售价格*/
    public $commission;/*店铺佣金*/
    public $agent_commission;/*代理佣金*/
    public $plat_commission;/*平台佣金*/
    public $com_inventories;/*店铺内总库存量*/
    public $com_inventoriesalarm;/*库存量警戒值*/
    public $supply_price;/*供货价*/
    public $isdel;/*是否删除*/
    public $inventories_store;/*库房库存*/
    public $inventories_front;/*前台库存*/
    public $inventories_sd;/*神灯库存*/
    public $cls;/*排序*/
    public $status;/*1 正常状态，2待审核 待审核无法销售*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    /**
     *字段验证规则 共模型插入时使用或者输入验证器使用
     */
    public static function rules()
    {
        return [
            /*'title'=>[
                'PresenceOf'=>new PresenceOf()
            ]*/
        ];
    }

    /*初始化*/
    public function initialize()
    {

    }

    /* 验证前的预置操作*/
    public function prepareSave()
    {

    }

    /**
     * 插入或者更新数据时验证 自动调取self::rules()方法返回的验证规则 其他特殊验证也可以写在这里  验证失败返回false即可
     * @return bool
     */
    public function validation()
    {
        $validator = $this->getDI()->get('validation');
        $allRule = self::rules();
        if (empty($allRule) || !is_array($allRule)) {
            return true;
        }
        foreach ($allRule as $k => $rules) {
            foreach ($rules as $rule) {
                $validator->add($k, $rule);
            }
        }
        return $this->validate($validator);
    }

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