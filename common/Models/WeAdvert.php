<?php

namespace Common\Models;

class WeAdvert  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $classid;
    public $title;
    public $url;
    public $readme;
    public $strcode;
    public $time1;
    public $time2;
    public $cls;
    public $img1;
    public $img2;
    public $flash;
    public $isuse;
    public $other;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_advert';
    }

    /**
     * @param mixed $parameters
     * @return WeAdvert[]|WeAdvert|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAdvert|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}