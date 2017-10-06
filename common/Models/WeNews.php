<?php

namespace Common\Models;

class WeNews  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $cid;
    public $cic;
    public $classid;
    public $classname;
    public $suid;
    public $snick;
    public $stime;
    public $ptime;
    public $euid;
    public $enick;
    public $etime;
    public $title;
    public $readme;
    public $preimg;
    public $mycontent;
    public $mycontentnojs;
    public $mytip;
    public $mytitle;
    public $mykeywords;
    public $mydescription;
    public $cls;
    public $isgood;
    public $hits;
    public $isshow;
    public $isdel;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_news';
    }

    /**
     * @param mixed $parameters
     * @return WeNews[]|WeNews|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeNews|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}