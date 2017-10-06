<?php

namespace Common\Models;

class CpLog  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*ID*/
    public $device_id;/*设备ID*/
    public $observe_event;/*观察事件*/
    public $door_number;/*门号*/
    public $post_time;/*提交时间*/
    public $post_type;/*请求类型*/
    public $order_number;/*订单号*/
    public $update_time;/*返回时间*/
    public $need_open_door;/*需要打开的仓门*/
    public $open_success_door;/*成功开启的仓门*/
    public $open_fail_door;/*开启失败的仓门*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'cp_log';
    }

    /**
     * @param mixed $parameters
     * @return CpLog[]|CpLog|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return CpLog|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}