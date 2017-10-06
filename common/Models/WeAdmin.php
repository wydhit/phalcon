<?php

namespace Common\Models;

class WeAdmin  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $u_id;
    public $u_name;
    public $u_pass;
    public $u_gic;
    public $u_gname;
    public $a_gic;
    public $a_gname;
    public $randcode;
    public $stime;
    public $euid;
    public $enick;
    public $etime;
    public $u_nick;/*称呼*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

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


}