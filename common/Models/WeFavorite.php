<?php

namespace Common\Models;

class WeFavorite  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $title;
    public $myid;
    public $myurl;/*地址*/
    public $mytypeid;/*类型*/
    public $mytype;
    public $uid;
    public $unick;
    public $stime;
    public $cls;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_favorite';
    }

    /**
     * @param mixed $parameters
     * @return WeFavorite[]|WeFavorite|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeFavorite|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}