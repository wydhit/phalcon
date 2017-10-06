<?php

namespace Common\Models;

class WeUplist  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ftype;
    public $fid;
    public $uid;
    public $u_nick;
    public $comid;
    public $myclassid;
    public $rootid;
    public $title;
    public $urlfile;
    public $urlthumb;
    public $utype;
    public $filesize;
    public $ufilewidth;
    public $ufileheight;
    public $isdel;
    public $stime;
    public $mytype;/*10=默认上传的*/
    public $fic;/*所属哪个记录的资源*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_uplist';
    }

    /**
     * @param mixed $parameters
     * @return WeUplist[]|WeUplist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeUplist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}