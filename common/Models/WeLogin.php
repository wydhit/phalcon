<?php

namespace Common\Models;

class WeLogin  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_id;
    public $u_name;
    public $u_nick;
    public $u_pass;
    public $u_ip;
    public $stime;
    public $mysource;
    public $comid;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_login';
    }

    /**
     * @param mixed $parameters
     * @return WeLogin[]|WeLogin|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeLogin|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}