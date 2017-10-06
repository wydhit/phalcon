<?php

namespace Common\Models;

class WeAdminLog  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $level;/*INFO一般记录WARNING警示记录ERROR错误记录*/
    public $action;/*操作*/
    public $action_name;/*操作名*/
    public $uid;
    public $uname;
    public $time_int;
    public $time;
    public $ip;
    public $server_data;/*$_SERVER 数据*/
    public $get_data;/*$_GET 数据*/
    public $post_data;/*$_POST 数据*/
    public $desc;/*有好的 可读的 说明  */
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_admin_log';
    }

    /**
     * @param mixed $parameters
     * @return WeAdminLog[]|WeAdminLog|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAdminLog|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}