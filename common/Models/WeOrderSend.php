<?php

namespace Common\Models;

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
    public $accept_type;/*是否强制送货
0默认未确认 
1 送货员验收验证确认
2 送货员强制确认
3 用户自己确认*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

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