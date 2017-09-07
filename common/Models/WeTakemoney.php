<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeTakemoney  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*申请提现操作人id*/
    public $agentid;/*代理商id*/
    public $comid;/*店铺id*/
    public $duid;/*后台操作人id*/
    public $myvalue;/*提现金额*/
    public $mystatus;/*状态*/
    public $stime;/*申请时间*/
    public $stimeint;/*申请时间*/
    public $etime;/*操作时间*/
    public $etimeint;/*操作时间*/
    public $fullname;/*账户名*/
    public $payname;
    public $paybank;
    public $payaccount;/*支付宝账户*/
    public $other;/*备注*/
    public $moneycomidlist;/*相关财务记录idlist*/
    public $type;/*agent 代理商提现  com 店铺提现*/
    public $formcode;/*通过后支付凭证号*/
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
        return 'we_takemoney';
    }

    /**
     * @param mixed $parameters
     * @return WeTakemoney[]|WeTakemoney|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeTakemoney|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}