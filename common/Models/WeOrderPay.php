<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeOrderPay  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $allprice;/*订单总额*/
    public $yue_price;/*余额支付金额*/
    public $zengkuan_price;/*赠款支付金额*/
    public $other_price;/*第三方支付金额= allprice-yue_price-zengkuan_price*/
    public $service_price;/*服务费-店内售卖人员送货产生的费用*/
    public $payway;/*支付方式*/
    public $stime;/*创建时间*/
    public $stimeint;/*创建时间*/
    public $ispayed;/*是否支付0未支付；1已支付*/
    public $stime_pay;/*支付时间*/
    public $pay_code;/*支付单号-系统自动生成非重复码*/
    public $trade_num;/*第三方支付交易号*/
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
        return 'we_order_pay';
    }

    /**
     * @param mixed $parameters
     * @return WeOrderPay[]|WeOrderPay|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrderPay|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}