<?php

namespace Common\Models;

class CpAlarm  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*ID*/
    public $device_id;/*设备ID*/
    public $alarm_event;/*报警事件*/
    public $bad_doors;/*异常门号*/
    public $is_repair;/*是否维修 0-等待维修 1-维修完毕*/
    public $post_time;/*报警事件*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'cp_alarm';
    }

    /**
     * @param mixed $parameters
     * @return CpAlarm[]|CpAlarm|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return CpAlarm|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}