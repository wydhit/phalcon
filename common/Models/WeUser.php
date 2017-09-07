<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeUser  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_name;/*登陆用户名大小写下划线数字 手机用户可以是手机号 */
    public $u_nick;/*昵称*/
    public $u_pass;/*密码*/
    public $randcode;/*密码加密码*/
    public $u_mail;/*邮箱*/
    public $u_gender;/*性别 男male 女female*/
    public $u_phone;/*电话*/
    public $u_mobile;/*手机*/
    public $u_face;/*头像*/
    public $u_regtimeint;/*注册时间*/
    public $u_regtime;
    public $reg_comid;/*从哪个店铺注册的*/
    public $u_lastlogintime;/*上次登录时间*/
    public $ischeck;/*0=未通过 1=通过 未通过无法登陆*/
    public $islock;/*0=未锁定 1=锁定 锁定无法登陆*/
    public $isdel;/*0=未删除 1=删除 删除无法登陆*/
    public $u_ip;/*注册账号的IP*/
    public $money;/*账户总额*/
    public $vmoney;/*虚拟货币-各种赠款*/
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
        return 'we_user';
    }

    /**
     * @param mixed $parameters
     * @return WeUser[]|WeUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}