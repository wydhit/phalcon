<?php

namespace Common\Models;

class WeSpecial  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $cid;
    public $title;
    public $tip;
    public $content;
    public $preimg;
    public $readme;
    public $cls;
    public $isgood;
    public $isopen;
    public $mytitle;
    public $mykeywords;
    public $mydescription;
    public $myurl;
    public $idlist;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_special';
    }

    /**
     * @param mixed $parameters
     * @return WeSpecial[]|WeSpecial|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSpecial|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}