<?php

namespace Common\Models;

class WeAccessBizer  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $name;/*操作名*/
    public $title;/*操作描述*/
    public $cls;/*排序*/
    public $pid;/*上级id  默认0为分类*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_access_bizer';
    }

    /**
     * @param mixed $parameters
     * @return WeAccessBizer[]|WeAccessBizer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAccessBizer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}