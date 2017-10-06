<?php

namespace Common\Models;

class WeComClassify  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $com_name;/*分类名*/
    public $cid;/*外键*/
    public $comid;
    public $able;/*状态*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_comClassify';
    }

    /**
     * @param mixed $parameters
     * @return WeComClassify[]|WeComClassify|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeComClassify|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}