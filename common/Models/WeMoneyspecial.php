<?php

namespace Common\Models;

class WeMoneyspecial  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*用户id*/
    public $unick;/*用户昵称*/
    public $myvalue;/*收入*/
    public $myvalueout;/*支出*/
    public $mytotal;/*当前值*/
    public $title;/*款项类型*/
    public $duid;/*操作人id*/
    public $dnick;/*操作人昵称*/
    public $mytype;/*款项说明*/
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
    public $myip;/*操作人ip*/
    public $comid;/*商家id*/
    public $comname;/*商家名称*/
    public $myrelation;/*相关记录id*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_moneyspecial';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyspecial[]|WeMoneyspecial|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneyspecial|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}