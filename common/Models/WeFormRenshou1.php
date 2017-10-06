<?php

namespace Common\Models;

class WeFormRenshou1  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $formid;/*问卷ID*/
    public $uid;/*用户ID*/
    public $stime;/*提交时间（显示）*/
    public $stimeint;/*提交时间（计算）*/
    public $f_fullname;/*问卷内填写的姓名*/
    public $f_mobile;/*问卷内填写的手机号码*/
    public $f_age;/*年龄*/
    public $f_marriage;/*婚育*/
    public $f_car;/*购车*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_form_renshou1';
    }

    /**
     * @param mixed $parameters
     * @return WeFormRenshou1[]|WeFormRenshou1|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeFormRenshou1|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}