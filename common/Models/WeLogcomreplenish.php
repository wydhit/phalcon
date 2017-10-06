<?php

namespace Common\Models;

class WeLogcomreplenish  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;
    public $unick;
    public $fullname;/*真实姓名*/
    public $comid;
    public $stime;
    public $stimeint;
    public $doorids;
    public $doortitles;
    public $mytype;/*补换货类型*/
    public $mytypename;/*补换货类型备注*/
    public $deviceid;
    public $placeid;/*铺位*/
    public $comgoodsids;
    public $goodstitles;
    public $historygoods;/*补换货的商品信息*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_logcomreplenish';
    }

    /**
     * @param mixed $parameters
     * @return WeLogcomreplenish[]|WeLogcomreplenish|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeLogcomreplenish|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}