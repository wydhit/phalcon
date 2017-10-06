<?php

namespace Common\Models;

class WeDoor extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;/*门号*/
    public $hasgoods;/*是否有商品，0无，1有*/
    public $mystatus;
    public $doorstatus;
    public $deviceid;/*设备id*/
    public $deviceic;/*设备mac*/
    public $comgoodsid;/*酒店商品id*/
    public $goodsid;/*商品id*/
    public $goodsic;/*商品ic*/
    public $comid;/*酒店id*/
    public $placeid;/*地点id*/
    public $ischange;/*是否换过货*/
    public $com_can_change_goods;/*店铺是否能更换柜门商品 0 不能 1 能*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_door';
    }

    /**
     * @param mixed $parameters
     * @return WeDoor[]|WeDoor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeDoor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    public static function getDoorOpenStatusTips($doorTitle = '', $badLocker = [], $goodLocker = [])
    {

        $okHtml = '<span class="btn btn-success btn-sm tooltip-success" data-rel="tooltip" data-placement="right" title="正常开门">正常开门</span>';
        $noHtml = '<span class="btn btn-danger btn-sm tooltip-success" data-rel="tooltip" data-placement="right" title="未正常开门">未正常开门</span>';
        $unknownHtml = '<span class="btn btn-warning btn-sm tooltip-success" data-rel="tooltip" data-placement="right" title="服务器没有获取到是否开门的任何信息">网络异常</span>';
        if (in_array($doorTitle, $goodLocker)) {
            return $okHtml;
        } elseif (in_array($doorTitle, $badLocker)) {
            return $noHtml;
        } else {
            return $unknownHtml;
        }
    }


}