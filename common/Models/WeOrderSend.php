<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeOrderSend  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*自增ID*/
    public $orderid;/*订单ID*/
    public $uid_send;/*送单员用户ID*/
    public $uname_send;/*送单员用户名称，来自user表的u_nick*/
    public $uid_accept;/*接单员用户ID*/
    public $uname_accept;/*接单员名称,来自user表的u_nick*/
    public $time_send;/*派送时间*/
    public $time_accept;/*接单时间*/
    public $type_send;/*派送状态  1接单；2收到*/
    public $method_send;/*送货类型：1：店内人员送货；2：平台送货；3：快递送货*/
    public $send_code;/*送货凭证号：发货凭号，快递单号*/
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
        return 'we_order_send';
    }

    /**
     * @param mixed $parameters
     * @return WeOrderSend[]|WeOrderSend|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrderSend|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}