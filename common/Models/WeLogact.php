<?php

namespace Common\Models;

class WeLogact  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*自增ID*/
    public $acttime;
    public $actuid;/*操作者id*/
    public $actnick;/*操作者昵称*/
    public $actgname;/*操作者姓名*/
    public $actip;/*操作者_IP*/
    public $actname;/*操作栏目名称（权限表中的名称）*/
    public $acturl;
    public $actcontent;/*json*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_logact';
    }

    /**
     * @param mixed $parameters
     * @return WeLogact[]|WeLogact|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeLogact|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}