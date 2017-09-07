<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeStore  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $goodsid;
    public $comgoodsid;/*商家商品id*/
    public $mycount;/*商品数量*/
    public $formcode;/*物流凭证号*/
    public $batch_num;/*商品批号*/
    public $duid;/*操作者id*/
    public $dname;/*操作者姓名*/
    public $uid;/*会员购买产生的记录会员id*/
    public $stime;/*记录时间*/
    public $stimeint;/*记录时间*/
    public $stroeto;
    public $storefrom;
    public $mytype;/*供应链编号组合12  32 ...*/
    public $other;/*备注*/
    public $comid;
    public $agentid;
    public $status;/*1待确认 2 已确认 3 取消*/
    public $rtimeint;/*确定时间*/
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
        return 'we_store';
    }

    /**
     * @param mixed $parameters
     * @return WeStore[]|WeStore|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeStore|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}