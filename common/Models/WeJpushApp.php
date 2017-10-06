<?php

namespace Common\Models;

class WeJpushApp  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*we_uer 表中的id*/
    public $comid;/*公司id*/
    public $rigistration_id;/*设备注册激光号 一个设备一个*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_jpush_app';
    }

    /**
     * @param mixed $parameters
     * @return WeJpushApp[]|WeJpushApp|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeJpushApp|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}