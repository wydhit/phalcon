<?php

namespace Common\Models;

class WeSuggest  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $sug_type_id;/*投诉类型*/
    public $sug_name;/*称呼*/
    public $contact;/*联系方式*/
    public $content;/*内容*/
    public $comid;/*店铺id*/
    public $placeid;/*铺位id*/
    public $sug_stimeint;
    public $sug_stime;
    public $severip;
    public $status;/*处理状态*/
    public $sug_type_name;/*投诉类型名称*/
    public $com_name;/*商户名称*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_suggest';
    }

    /**
     * @param mixed $parameters
     * @return WeSuggest[]|WeSuggest|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeSuggest|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}