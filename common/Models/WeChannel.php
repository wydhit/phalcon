<?php

namespace Common\Models;

class WeChannel  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;
    public $mytip;
    public $mytitle;
    public $mykeywords;
    public $mydescription;
    public $readme;
    public $content;
    public $cha_url;
    public $cha_dir;
    public $cha_set;
    public $cha_moduleid;
    public $cha_module;
    public $cha_modulename;
    public $cha_count;
    public $cha_show;
    public $cha_opentype;
    public $cls;
    public $cha_type;
    public $cha_typename;
    public $cha_unit;
    public $isuse;
    public $cha_page;
    public $cha_style;
    public $cha_other;
    public $preimg;
    public $icanghost;
    public $mytype;
    public $cha_mdb;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_channel';
    }

    /**
     * @param mixed $parameters
     * @return WeChannel[]|WeChannel|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeChannel|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}