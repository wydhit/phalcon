<?php

namespace Common\Models;

use Common\Core\BaseValidation;
use Common\Exception\LogicException;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class WeAdmin  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_id;/*如果这个管理员也是会员 对应的会员id */
    public $u_name;/*登录用的用户名 只允许大小写数字*/
    public $u_nick;/*称呼*/
    public $u_pass;/*密码*/
    public $u_gid;/*用户组id*/
    public $u_gic;/*用户组*/
    public $u_roleid;/*角色id*/
    public $u_roleic;
    public $randcode;/*密码加密*/
    public $stime;/*创建时间*/
    public $euid;/*创建人id*/
    public $islock;/*1锁定无法登陆*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    /**
     *字段验证规则 供模型插入时使用或者输入验证器使用
     */
    public static function rules()
    {

        return [
            'u_name'=>[
                'PresenceOf'=>new PresenceOf(),
                'StringLength'=>new StringLength(['max'=>50,'min'=>3]),
                'Alnum'=>new Alnum(),
            ],
            'u_nick'=>[
                'PresenceOf'=>new PresenceOf(),
                'StringLength'=>new StringLength(['max'=>50,'min'=>1]),
            ],
            'u_pass'=>[
                'PresenceOf'=>new PresenceOf(),
            ],
            'islock'=>[
                'InclusionIn'=>new InclusionIn(['domain'=>[0,1],'message'=>'锁定状态错误']),
            ]
        ];
    }

    /*初始化*/
    public function initialize()
    {
        $this->hasOne('u_gid',WeGroup::class,'id',['alias'=>'belongGroup']);
        $this->hasOne('u_roleid',WeGroup::class,'id',['alias'=>'belongRole']);

    }

    /* 验证前的预置操作*/
    public function prepareSave()
    {

    }

    /**
     * 两种方式验证数据
     * 1、使用独立验证器  DataValidation::validWithException($this);DataValidation是事先定义好的验证器及规则
     * 2、新建验证器
     *      $validator=new BaseValidation();
     *      $validation->add('id',new PresenceOf());
     *      1、return $this->validate($validator);//返回验证结果需要在控制处理验证信息
     *      2、return $this->validateWithException($validation);//验证不通过抛出异常，异常将自动响应输出验证信息
     * 插入或者更新数据时验证 自动调取self::rules()方法返回的验证规则 其他特殊验证也可以写在这里  验证失败返回false即可
     * @return bool
     */
    public function validation()
    {
        /*1*/
        BaseValidation::validWithException($this);
        return BaseValidation::valid($this);
        /*2*/
        $validator = $this->getDI()->get('validation');
        $allRule = self::rules();
        $validator=new BaseValidation();
        $validator->addRuleFromModel(self::class);
        $validator->addRuleFromArray(self::rules());
        $validator->addPresenceOfRules('ss');
        return $this->validate($validator);
    }

    public function getSource()
    {
        return 'we_admin';
    }

    /**
     * @param mixed $parameters
     * @return WeAdmin[]|WeAdmin|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAdmin|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }
    public function checkPwd($password)
    {
        return $this->getTruePass($password) === $this->u_pass;

    }

    public function getTruePass($password)
    {
        return md5($this->randcode . $password);
    }





}