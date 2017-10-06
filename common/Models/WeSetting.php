<?php

namespace Common\Models;

class WeSetting  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $cid;
    public $myname;
    public $title;
    public $titleshow;
    public $readme;
    public $mydata;
    public $cls;
    public $mytype;
    public $isshow;
    public $mustfill;
    public $isother;
    public $fieldtype;
    public $fieldoption;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_setting';
    }

    /**
     * @param mixed $parameters
     * @return WeSetting[]|WeSetting|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSetting|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}