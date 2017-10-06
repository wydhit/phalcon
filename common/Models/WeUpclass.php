<?php

namespace Common\Models;

class WeUpclass  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $cid;
    public $uid;
    public $comid;
    public $title;
    public $readme;
    public $cls;
    public $preimg;
    public $isuse;
    public $issys;
    public $dir;
    public $ftype;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_upclass';
    }

    /**
     * @param mixed $parameters
     * @return WeUpclass[]|WeUpclass|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeUpclass|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}