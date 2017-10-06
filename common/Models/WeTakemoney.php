<?php

namespace Common\Models;

class WeTakemoney  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*所属用户id*/
    public $comid;/*店铺id*/
    public $u_gic;/*哪个用户组的*/
    public $duid;/*操作人id*/
    public $myvalue;/*提现金额*/
    public $mystatus;/*状态*/
    public $stime;
    public $stimeint;
    public $fullname;/*账户名*/
    public $payname;
    public $paybank;
    public $payaccount;/*支付宝账户*/
    public $other;/*备注*/
    public $moneycomidlist;/*相关财务记录idlist*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_takemoney';
    }

    /**
     * @param mixed $parameters
     * @return WeTakemoney[]|WeTakemoney|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeTakemoney|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}