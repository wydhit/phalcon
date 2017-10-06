<?php

namespace Common\Models;

class WeArea  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $szcode;
    public $title;
    public $pinyin;
    public $citymark;/*城市拼音首字母代号*/
    public $pid;
    public $isleaf;
    public $idpath;
    public $idpathv;
    public $mytype;
    public $myclass;/*0=地区,10=商圈*/
    public $depth;
    public $content;
    public $isopen;
    public $isuse;
    public $cls;
    public $iscentercity;
    public $ishot;/*是否热点城市*/
    public $longitude;/*经度*/
    public $latitude;/*纬度*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_area';
    }

    /**
     * @param mixed $parameters
     * @return WeArea[]|WeArea|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeArea|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}