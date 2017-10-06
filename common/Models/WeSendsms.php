<?php

namespace Common\Models;

class WeSendsms  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $sendmobile;
    public $sendmsg;
    public $sendinfo;
    public $sendtimeint;
    public $sendtypename;
    public $sendtype;
    public $sendip;
    public $senduid;
    public $sendduid;
    public $sendcomid;
    public $sendstate;
    public $sendmsgstate;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_sendsms';
    }

    /**
     * @param mixed $parameters
     * @return WeSendsms[]|WeSendsms|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSendsms|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}