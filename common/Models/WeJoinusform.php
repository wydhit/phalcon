<?php

namespace Common\Models;

class WeJoinusform  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $f_name;/*姓名*/
    public $f_mobile;/*电话*/
    public $f_field;/*行业*/
    public $f_message;/*留言*/
    public $stime;/*时间*/
    public $stimeint;/*时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_joinusform';
    }

    /**
     * @param mixed $parameters
     * @return WeJoinusform[]|WeJoinusform|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeJoinusform|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}