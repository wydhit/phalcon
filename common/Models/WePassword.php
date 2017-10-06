<?php

namespace Common\Models;

class WePassword  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $rand_code;/*随机数*/
    public $hotelid;
    public $uid;
    public $u_mobile;
    public $stime;/*链接生成时间*/
    public $etime;/*链接结束时间*/
    public $pass_url;/*链接地址*/
    public $u_mail;
    public $title;/*找回密码标题*/
    public $mailbody;/*邮件内容*/
    public $myip;
    public $isone;
    public $rand;
    public $sendform;/*来源*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_password';
    }

    /**
     * @param mixed $parameters
     * @return WePassword[]|WePassword|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WePassword|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}