<?php

namespace Common\Models;

class WeMenu  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $title;
    public $titlecode;
    public $url;
    public $para;
    public $pid;
    public $idpath;
    public $power;
    public $cls;
    public $cid;
    public $plusid;
    public $menuid;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_menu';
    }

    /**
     * @param mixed $parameters
     * @return WeMenu[]|WeMenu|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMenu|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}