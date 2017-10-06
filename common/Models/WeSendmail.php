<?php

namespace Common\Models;

class WeSendmail  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $sendmail;/*发送邮件地址*/
    public $frommail;/*发件地址*/
    public $fromname;/*发件人*/
    public $sendsubject;/*邮件主题*/
    public $sendmsg;/*发送邮件内容*/
    public $sendip;/*发送邮件IP*/
    public $sendtime;/*发送邮件时间*/
    public $sendtimeint;/*发送邮件时间戳*/
    public $senduid;/*发送人ID*/
    public $sendduid;/*收件人ID*/
    public $others;/*备注*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_sendmail';
    }

    /**
     * @param mixed $parameters
     * @return WeSendmail[]|WeSendmail|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSendmail|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}