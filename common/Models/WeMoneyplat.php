<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeMoneyplat  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $myvalue;/*收入*/
    public $myvalueout;/*支出*/
    public $mytotal;/*当前值*/
    public $orderid;/*来自订单id*/
    public $title;/*款项类型*/
    public $duid;/*操作人id*/
    public $dnick;/*操作人昵称*/
    public $mytype;/*款项说明*/
    public $mytypename;
    public $myway;/*入款方式标识*/
    public $mywayname;/*打款方式*/
    public $formcode;/*原始评证号*/
    public $stimeint;/*提交时间（计算）*/
    public $stime;/*提交时间（显示）*/
    public $isdel;/*是否删除，0=未删除，1=删除*/
    public $other;/*备注*/
    public $myip;/*操作人ip*/
    public $comid;/*商家id*/
    public $myfrom;/*shendeng神灯销售、diannei店内售*/
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
        return 'we_moneyplat';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyplat[]|WeMoneyplat|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyplat|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}