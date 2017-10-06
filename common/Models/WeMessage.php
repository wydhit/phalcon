<?php

namespace Common\Models;

class WeMessage  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $mic;/*模块标识，属于哪个模块*/
    public $pid;/*属于哪条记录的id*/
    public $pic;/*属于哪条记录的ic*/
    public $uid;
    public $unick;/*昵称*/
    public $euid;
    public $eunick;
    public $stime;/*发表时间*/
    public $stimeint;
    public $etime;/*修改时间*/
    public $etimeint;
    public $isreview;/*是否审核过了*/
    public $isgood;/*是否推荐*/
    public $isdel;/*是否删除*/
    public $ip;/*ip地址*/
    public $myname;/*留言者姓名*/
    public $mytel;/*留言者电话*/
    public $recallperiod;/*回访时段*/
    public $email;/*邮箱*/
    public $address;/*地址*/
    public $mycontent;/*内容*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_message';
    }

    /**
     * @param mixed $parameters
     * @return WeMessage[]|WeMessage|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMessage|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}