<?php

namespace Common\Models;

class WeSpecialroomlist  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $hotelid;
    public $hotelname;
    public $roomid;
    public $roomname;
    public $mydate;
    public $mydatefm;
    public $roomsupply;/*供应量*/
    public $roomremain;/*剩余几间空房*/
    public $roomorder;/*累计预定量*/
    public $roomselled;/*已售量*/
    public $roomsum;/*累计销售量*/
    public $isopen;
    public $price10;
    public $price20;
    public $price30;
    public $price;
    public $savetime1;
    public $savetime2;
    public $mystatus;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_specialroomlist';
    }

    /**
     * @param mixed $parameters
     * @return WeSpecialroomlist[]|WeSpecialroomlist|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSpecialroomlist|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}