<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeMoneyagent  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*代理商id*/
    public $comid;/*收入来自商家id*/
    public $myvalue;/*收入*/
    public $myvalueout;/*支出*/
    public $mytotal;/*当前账户余额*/
    public $orderid;/*订单id*/
    public $mytype;/*财务类型编号*/
    public $mytypename;/*财务类型说明*/
    public $duid;/*操作人id 管理员id 佣金等不记录用户id 为0*/
    public $stimeint;/*提交时间（计算）*/
    public $stime;/*提交时间（显示）*/
    public $etimeint;/*修改时间（计算）*/
    public $etime;/*修改时间（显示）*/
    public $other;/*备注*/
    public $myip;/*操作人ip*/
    public $myway;/*款项途径（如支付宝或者网银或者现金）*/
    public $mywayname;/*款项款项途径名称*/
    public $formcode;/*原始评证号*/
    public $title;/*款项说明*/
    public $myfrom;/*shendeng神灯销售、diannei店内售*/
    public $paymentstatus;/*0表示未结款，1表示对账中，2表示已冻结，3表示已结款*/
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
        return 'we_moneyagent';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyagent[]|WeMoneyagent|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyagent|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}