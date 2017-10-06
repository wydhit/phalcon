<?php

namespace Common\Models;

class WeDevice  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;/*设备mac*/
    public $typeic;
    public $doornum;/*格子机门数目*/
    public $goodsnum;/*商品数目*/
    public $isrun;/*是否运行*/
    public $placeic;/*地点ic*/
    public $placeid;/*地点id*/
    public $comid;/*店铺id*/
    public $comic;/*店铺ic*/
    public $stimeint;/*添加时间*/
    public $mystatus;/*设备实时状态doing运行down断开*/
    public $serverip;/*node服务器的ip地址*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_device';
    }

    /**
     * @param mixed $parameters
     * @return WeDevice[]|WeDevice|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeDevice|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}