<?php

namespace Common\Models;

class WeAlbum  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comtype;/*hotel*/
    public $comid;
    public $stime;
    public $suid;
    public $snick;
    public $euid;
    public $enick;
    public $etime;
    public $cls;
    public $title;
    public $myurl;
    public $mywidth;
    public $myheight;
    public $mysize;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_album';
    }

    /**
     * @param mixed $parameters
     * @return WeAlbum[]|WeAlbum|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAlbum|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}