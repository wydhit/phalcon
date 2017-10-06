<?php

namespace Common\Models;

use Common\Core\BaseValidation;
use Common\Exception\LogicException;
use Common\Exception\ModelExExecuteException;
use Common\Helpers\HttpHelper;
use Common\Validator\MobileValidator;
use Phalcon\Security\Random;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;
use Phalcon\Validation\Validator\Uniqueness;
use function Sodium\add;

class WeUser extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_gic;/*用户组标识*/
    public $u_gname;/*用户组名称*/
    public $u_roleic;/*角色ic*/
    public $u_rolename;/*角色名称*/
    public $u_name;/*用户名*/
    public $u_pass;/*密码*/
    public $u_paypwd;/*支付密码*/
    public $u_mail;/*邮箱*/
    public $u_gender;
    public $u_phone;/*电话*/
    public $u_mobile;/*手机*/
    public $u_face;/*头像*/
    public $u_regtimeint;/*注册时间*/
    public $u_regtime;
    public $u_endtimeint;/*账号到期时间*/
    public $u_endtime;
    public $u_point;/*积分*/
    public $u_nick;/*称呼*/
    public $u_fullname;/*真实姓名*/
    public $u_countshortmess;/*短消息数量*/
    public $u_atime;/*上一次活动时间*/
    public $u_lastlogintime;/*上次登录时间*/
    public $u_blacklist;/*黑名单*/
    public $u_err;/*登录错误次数*/
    public $u_searchpasserr;/*查找错误次数*/
    public $u_searchpasserrtime;/*查找错误时间*/
    public $stimeint;/*提交时间*/
    public $stime;
    public $suid;/*提交个人ID*/
    public $snick;
    public $etimeint;/*编辑时间*/
    public $etime;
    public $euid;
    public $enick;
    public $ischeck;/*0=未通过 1=通过*/
    public $islock;/*0=未锁定 1=锁定*/
    public $isdel;/*0=未删除 1=删除*/
    public $u_ip;/*注册账号的IP*/
    public $u_online;/*是否在线*/
    public $u_ismaster;/*是否是管理员*/
    public $randcode;/*验证码*/
    public $crandcode;/*随机码,用于保存cookie,每次存用户cookie,这个码变一次*/
    public $hashotel;/*是否开通了酒店*/
    public $aall;/*账户总额*/
    public $acanuse;/*可用余额*/
    public $ain;/*充值总额*/
    public $aincome;/*收益总额*/
    public $aout;/*出款总额*/
    public $afrize;/*冻结款项*/
    public $agiveprice;/*赠金*/
    public $u_idcode;/*身份证号码*/
    public $recommend_id;/*推荐人id*/
    public $recommend_nick;/*推荐人昵称*/
    public $comid;/*机构id(酒店id，饭店id...)*/
    public $comname;
    public $comisdel;/*商家删除用户标记*/
    public $u_payerr;/*支付密码错误次数*/
    public $firstorder;/*首单优惠标志*/
    public $ischeckmail;/*邮箱是否验证过*/
    public $isinfo;/*完善资料发放e家币标志位*/
    public $u_source;/*会员来源*/
    public $creditlevel;/*会员信用等级*/
    public $level;/*会员等级*/
    public $u_grow;/*成长值*/
    public $vmoney;/*虚拟货币-各种赠款*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/
    public $agentid;/*代理商id*/

    const allIscheckType = [
        0 => '未审核',
        1 => '已审核'
    ];
    const allIslockType = [
        0 => '正常',
        1 => '锁定'
    ];


    public function initialize()
    {
        $this->hasOne('u_gic', WeGroup::class, 'ic', ['alias' => 'belongGroup']);
        $this->hasOne('u_roleic', WeGroup::class, 'ic', ['alias' => 'belongRole']);
        $this->hasMany('id', WeCom::class, 'uid', ['alias' => 'com']);
    }

    public function getSource()
    {
        return 'we_user';
    }

    public static function rules()
    {
        return [
            'u_gic' => ['PresenceOf' => new PresenceOf()],
            'u_roleic' => ['PresenceOf' => new PresenceOf()],
            'u_name' => [
                'PresenceOf' => new PresenceOf(),
                'StringLength'=>new StringLength(['max'=>50,'min'=>3])
            ],
            'u_mail'=>[
                'Email'=>new Email(),
            ],
            'u_mobile'=>[
                'Mobile'=>new MobileValidator(),
            ],
            'u_nick'=>[
                'StringLength'=>new StringLength(['max'=>50,'min'=>1])
            ],
            'u_fullname'=>[
                'StringLength'=>new StringLength(['max'=>50,'min'=>1])
            ]
        ];
    }

    public static function labels()
    {
        return [
            'id' => "Id",
            'u_gic' => '用户组标识',
            'u_gname' => '用户组名称',
            'u_roleic' => '角色标识',
            'u_rolename' => '角色名称',
            'u_name' => '用户名',
            'u_pass' => '密码',
            'u_mail' => '邮箱',
            'u_gender' => '性别',
            'u_phone' => '电话',
            'u_mobile' => '手机',
            'u_face' => '头像',
            'u_regtimeint' => '注册时间',
            'u_regtime' => '注册时间',
            'u_endtimeint' => '账号到期时间',
            'u_endtime' => '',
            'u_point' => '积分',
            'u_nick' => '称呼',
            'u_fullname' => '真实姓名',
            'u_countshortmess' => '短消息数量',
            'u_atime' => '上一次活动时间',
            'u_lastlogintime' => '上次登录时间',
            'u_blacklist' => '黑名单',
            'u_err' => '登录错误次数',
            'u_searchpasserr' => '查找错误次数',
            'u_searchpasserrtime' => '查找错误时间',
            'stimeint' => '提交时间',
            'stime' => '提交时间',
            'suid' => '提交个人ID',
            'snick' => '提交个人昵称',
            'etimeint' => '编辑时间',
            'etime' => 'etime',
            'euid' => 'euid',
            'enick' => 'enick',
            'ischeck' => '审核状态',
            'islock' => '锁定状态',
            'isdel' => '删除状态',
            'u_ip' => '注册账号的IP',
            'u_online' => '是否在线',
            'u_ismaster' => '是否是管理员',
            'randcode' => '验证码',
            'crandcode' => 'cookie随机码',
            'hashotel' => '是否开通了酒店',
            'aall' => '账户总额',
            'acanuse' => '可用余额',
            'ain' => '充值总额',
            'aincome' => '收益总额',
            'aout' => '出款总额',
            'afrize' => '冻结款项',
            'agiveprice' => '赠金',
            'u_idcode' => '身份证号码',
            'recommend_id' => '推荐人id',
            'recommend_nick' => '推荐人昵称',
            'comid' => '机构id(酒店id，饭店id...)',
            'comname' => 'comname',
            'comisdel' => '商家删除用户标记',
            'u_payerr' => '支付密码错误次数',
            'firstorder' => '首单优惠标志',
            'ischeckmail' => '邮箱是否验证过',
            'isinfo' => '完善资料发放e家币标志位',
            'u_source' => '会员来源',
            'creditlevel' => '会员信用等级',
            'level' => '会员等级',
            'u_grow' => '成长值',
            'vmoney' => '虚拟货币 - 各种赠款',
            'agentid' => '代理商id'
        ];
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

    public function checkPwd($password)
    {
        return $this->getTruePassWord($password) === $this->u_pass;
    }

    public function getTruePassWord($password)
    {
        return md5($password . $this->randcode);
    }


    public static function getIscheckTips($value)
    {
        $all = self::allIscheckType;
        if (isset($all[$value])) {
            return $all[$value];
        } else {
            return '未知';
        }
    }

    public static function getIslockTips($value)
    {
        $all = self::allIslockType;
        if (isset($all[$value])) {
            return $all[$value];
        } else {
            return '未知';
        }
    }

    public function validation()
    {
        $validation = new BaseValidation();
        $validation->add('ischeck', new InclusionIn(['domain' => ['1', '0'], 'message' => '请正确输入审核状态']));
        $validation->add('islock', new InclusionIn(['domain' => ['1', '0'], 'message' => '请正确输入锁定状态']));
        $validation->add('isdel', new InclusionIn(['domain' => ['1', '0'], 'message' => '请正确输入删除状态']));
        return $this->validate($validation);
    }

    /**
     * @param $data array  用户数据
     * 必填字段[
     *  'u_gic'=>'用户组ic 必须group表中存在',
     *  'u_roleic'=>'用户角色ic 必须group表中存在在u_gic下',
     *  'u_name'=>'登录用户',
     *  'u_pass'=>'密码',
     *  'u_pass_c'=>'确认密码',
     *  'u_mobile'=>'手机号 用户组内不得重复',
     *  'u_nick'=>'昵称',
     * ]
     * 选填[
     *  ''
     * ]
     * @return $this
     * @throws LogicException
     */
    public function addUser($data = [])
    {
        $this->addInitUserinfo();//和输入无关的初始化*/

        $this->assign($data);
        $this->u_gname = WeGroup::getTitleByIc($this->u_gic);
        if (empty($this->u_gname)) {
            throw new LogicException('用户组不存在');
        }
        $this->u_rolename = WeGroup::getTitleByIc($this->u_roleic, $this->u_gic);
        if (empty($this->u_rolename)) {
            throw new LogicException('用户角色不存在');
        }
        if ($this->checkIsExist('u_name')) {
            throw new LogicException('用户名已存在');
        }
        $this->u_pass = $this->getTruePassWord($this->u_pass);
        if (empty($this->u_nick) && empty($this->u_fullname)) {
            throw new LogicException('用户昵称不能为空');
        }

        if ($this->checkIsExist('u_mobile', 'u_gic =:u_gic:', ['u_gic' => $this->u_gic])) {
            throw new LogicException('手机号重复');
        }
        $this->saveWithException();
        return $this;
    }

    /**
     *
     * 新增用户时初始化用户默认信息
     */
    public function addInitUserinfo()
    {
        $this->u_face = ' / img / noface . png'; //默认头像
        $this->u_err = 0;
        $this->u_searchpasserr = 0;
        $this->u_searchpasserrtime = time();
        $this->etimeint = time();
        $this->etime = date('Y - m - d H:i:s');
        $this->stimeint = time();
        $this->stime = date('Y - m - d H:i:s', $this->stimeint);
        $this->ischeck = 1;
        $this->islock = 0;
        $this->isdel = 0;
        $this->u_regtimeint = time();
        $this->u_regtime = date('Y - m - d H:i:s', $this->u_regtimeint);
        $this->randcode = $this->getRandCode();
        $this->u_ip = HttpHelper::getIp();;
    }

    /**
     * 获取密码加密盐
     * @return string
     */
    private function getRandCode()
    {
        $random = new Random();
        return $random->base64(8);
    }

    public function editPass($pass = '')
    {
        $this->u_pass = $this->getTruePassWord($pass);
        $this->saveWithException();
    }

    public function sysBizerDel()
    {
        if ($this->com->count() > 0) {
            throw new ModelExExecuteException('该用户下还有店铺，不能删除');
        } else {
            return $this->softDel();
        }
    }


}