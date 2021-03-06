<?php

namespace Common\Models;

class WeMoneyuser  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*用户id*/
    public $unick;/*用户昵称*/
    public $myvalue;/*收入*/
    public $myvalueout;/*支出*/
    public $mytotal;/*当前余额*/
    public $orderid;/*订单id*/
    public $m_status;/*财务状态*/
    public $title;/*款项说明*/
    public $duid;/*操作人id*/
    public $dnick;/*操作人昵称*/
    public $mytype;/*款项类型标识*/
    public $mytypename;
    public $tradetype;/*交易类型*/
    public $myway;/*入款方式标识*/
    public $mywayname;/*打款方式*/
    public $formcode;/*原始评证号*/
    public $formdate;/*原始评证日期*/
    public $moneycode;/*到账评证号*/
    public $moneydate;/*到账评证日期*/
    public $stimeint;/*提交时间（计算）*/
    public $stime;/*提交时间（显示）*/
    public $isdel;/*是否删除，0=未删除，1=删除*/
    public $ispass;/*状态,0=未审核,1=审核*/
    public $other;/*备注*/
    public $moneytype;/*1=入款, 2=出款*/
    public $myip;/*操作人ip*/
    public $comid;
    public $comname;
    public $u_paymail;/*支付宝账号*/
    public $myfrom;/*shendeng神灯销售、diannei店内售*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_moneyuser';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyuser[]|WeMoneyuser|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyuser|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}