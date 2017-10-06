<?php

namespace Common\Models;

class WeFailtofix  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comname;/*酒店名称*/
    public $address;/*地点*/
    public $tel;/*电话*/
    public $building;/*楼栋*/
    public $floor;/*楼层*/
    public $title;/*房间*/
    public $deviceic;/*设备ic*/
    public $door;/*门号*/
    public $type;/*类型*/
    public $status;
    public $isend;/*此条记录是否修复，1已修复，0未修复*/
    public $cal;
    public $stime;/*时间*/
    public $stimeint;/*时间*/
    public $repairtime;/*自动修复时间*/
    public $comid;/*酒店id*/
    public $placeid;/*地点id*/
    public $mytype;/*错误类型*/
    public $mytypename;/*错误类型对应名称*/
    public $repairtimeint;/*维修时间*/
    public $ischange;/*酒店是否送过货，已送过1*/
    public $goodstitle;/*商品名称*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_failtofix';
    }

    /**
     * @param mixed $parameters
     * @return WeFailtofix[]|WeFailtofix|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeFailtofix|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}