<?php

namespace Common\Models;

class WeUploaduser  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_mobile;/*手机*/
    public $u_nick;/*称呼*/
    public $u_pass;/*密码*/
    public $u_idcode;/*身份证号码*/
    public $stimeint;/*提交时间*/
    public $stime;
    public $hotelid;/*酒店id*/
    public $hoteltitle;/*酒店名称*/
    public $suid;/*提交个人ID*/
    public $snick;/*提交个人昵称*/
    public $randcode;/*验证码*/
    public $iseffect;/*是否有效*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_uploaduser';
    }

    /**
     * @param mixed $parameters
     * @return WeUploaduser[]|WeUploaduser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeUploaduser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}