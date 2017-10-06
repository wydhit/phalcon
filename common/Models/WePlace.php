<?php

namespace Common\Models;

class WePlace  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;/*地点名称*/
    public $building;/*楼栋*/
    public $floor;/*楼层*/
    public $comid;/*店铺id*/
    public $comic;/*店铺ic*/
    public $cls;/*排序*/
    public $isdel;/*是否删除*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_place';
    }

    /**
     * @param mixed $parameters
     * @return WePlace[]|WePlace|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WePlace|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}