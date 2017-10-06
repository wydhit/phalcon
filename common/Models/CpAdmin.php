<?php

namespace Common\Models;

class CpAdmin  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*ID*/
    public $username;/*账号*/
    public $password;/*密码*/
    public $realname;/*真实姓名*/
    public $create_time;/*创建时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'cp_admin';
    }

    /**
     * @param mixed $parameters
     * @return CpAdmin[]|CpAdmin|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return CpAdmin|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}