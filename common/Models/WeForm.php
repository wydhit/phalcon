<?php

namespace Common\Models;

class WeForm  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;/*问卷IC*/
    public $aic;/*所属广告公司IC*/
    public $comid;/*店铺ID*/
    public $title;/*问卷名称*/
    public $readme;/*说明*/
    public $myvalue;/*赠送金额*/
    public $mycount;/*问卷总份数*/
    public $questioncount;/*题数*/
    public $plantime;/*预计答题时间*/
    public $donecount;/*完成份数*/
    public $suid;/*提交人ID*/
    public $stime;/*上传时间（显示）*/
    public $stimeint;/*上传时间（计算）*/
    public $overtime;/*到期时间*/
    public $mystatus;/*状态*/
    public $openness;/*开放度*/
    public $getgrant;/*已领赠款人数*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_form';
    }

    /**
     * @param mixed $parameters
     * @return WeForm[]|WeForm|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeForm|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}