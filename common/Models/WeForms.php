<?php

namespace Common\Models;

class WeForms  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comname;/*广告商名称*/
    public $name;/*调查名称*/
    public $des;/*调查说明*/
    public $money;/*返现金额*/
    public $totalcount;/*需要调查数量*/
    public $answertime;/*答题预计时间*/
    public $endtime;/*到期时间*/
    public $openness;/*开放度*/
    public $answercount;/*答卷人数*/
    public $creattime;/*建立时间*/
    public $updatetime;/*更新时间*/
    public $userid;/*提交人*/
    public $status;/*状态0关闭 1开启*/
    public $isdel;
    public $formType;/*问卷调查类型 common 通用 tree 树状跳转*/
    public $comids;/*那些酒店开启这个问卷调查，为空则所有酒店开启*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_forms';
    }

    /**
     * @param mixed $parameters
     * @return WeForms[]|WeForms|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeForms|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}