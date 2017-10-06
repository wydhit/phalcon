<?php

namespace Common\Models;

class WeCheck  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*所属用户id*/
    public $comid;/*店铺id*/
    public $u_gic;/*哪个用户组的*/
    public $duid;/*操作人id*/
    public $myvalue;/*对账金额*/
    public $mystatus;/*new:待确认，checked：已确认，takeing:提现中，payed：已结款，cancel：已取消*/
    public $stime;
    public $stimeint;/*操作日期*/
    public $fullname;/*真实姓名*/
    public $payname;/*账户名称*/
    public $paybank;/*开户行*/
    public $payaccount;/*账号*/
    public $other;/*备注*/
    public $moneycomidlist;/*相关财务记录idlist*/
    public $starttime;/*对账区间起始日期*/
    public $endtime;/*对账区间结束日期*/
    public $starttimeint;
    public $endtimeint;
    public $comname;/*酒店名称*/
    public $telfront;/*电话*/
    public $comic;/*店铺ic*/
    public $dnick;/*昵称*/
    public $takemoneyid;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_check';
    }

    /**
     * @param mixed $parameters
     * @return WeCheck[]|WeCheck|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCheck|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}