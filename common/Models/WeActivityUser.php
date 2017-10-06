<?php

namespace Common\Models;

class WeActivityUser  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $activity_id;/*参与活动ID*/
    public $clerk_uid;/*参与店员we_user id*/
    public $clerk_unick;/*店员昵称*/
    public $customer_uid;/*参与用户we_user id*/
    public $customer_mobile;/*用户手机号*/
    public $comid;/*商家id*/
    public $stimeint;/*创建时间*/
    public $status;/*参与活动状态：1 参与-注册；2、登录；3、购买*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_activity_user';
    }

    /**
     * @param mixed $parameters
     * @return WeActivityUser[]|WeActivityUser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeActivityUser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}