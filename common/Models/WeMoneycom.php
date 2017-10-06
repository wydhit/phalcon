<?php

namespace Common\Models;

class WeMoneycom  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*商家id*/
    public $unick;/*商家昵称*/
    public $myvalue;/*收入*/
    public $myvalueout;/*支出*/
    public $mytotal;/*当前值*/
    public $orderid;/*订单id*/
    public $paymentstatus;/*0表示未结款，1表示对账中，2表示已冻结，3表示已结款*/
    public $title;/*款项说明*/
    public $duid;/*操作人id*/
    public $dnick;/*操作人昵称*/
    public $mytype;/*款项说明*/
    public $mytypename;
    public $myway;/*款项类型标识*/
    public $mywayname;/*款项类型名称*/
    public $formcode;/*原始评证号*/
    public $formdate;/*原始评证日期*/
    public $moneycode;/*到账评证号*/
    public $moneydate;/*到账评证日期*/
    public $stimeint;/*提交时间（计算）*/
    public $stime;/*提交时间（显示）*/
    public $isdel;/*是否删除，0=未删除，1=删除*/
    public $ispass;/*状态,0=未审核,1=审核*/
    public $other;/*备注*/
    public $moneytype;/*10=入款, 20=出款*/
    public $tradetype;/*交易类型，虚拟或实际*/
    public $myip;/*操作人ip*/
    public $comid;/*商家id*/
    public $comname;/*商家名称*/
    public $paymentday;/*账期*/
    public $ispayed;/*是否已经支付给商家*/
    public $myrelation;/*相关记录id*/
    public $myfrom;/*shendeng神灯销售、diannei店内售*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_moneycom';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneycom[]|WeMoneycom|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneycom|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}