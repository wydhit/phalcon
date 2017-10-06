<?php

namespace Common\Models;

class WeContact  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $c_name;
    public $c_job;
    public $c_mobile;
    public $c_tel1a;
    public $c_tel1b;
    public $c_tel2a;
    public $c_tel2b;
    public $c_mail;
    public $comid;
    public $classid;
    public $title;
    public $cls;
    public $comtype;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_contact';
    }

    /**
     * @param mixed $parameters
     * @return WeContact[]|WeContact|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeContact|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}