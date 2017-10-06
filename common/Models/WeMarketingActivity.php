<?php

namespace Common\Models;

class WeMarketingActivity  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $act_title;
    public $act_ic;/*活动标识*/
    public $time_start;/*活动开始时间*/
    public $time_start_int;
    public $time_end;/*活动结束时间*/
    public $time_end_int;
    public $act_status;/*活动状态：1草稿；2开启；2关闭；*/
    public $send_type;/*发送类型：1酒店自提；2固定送达；3快递送货；*/
    public $act_user;/*参与人员:1散客；2会员；3酒店员工；*/
    public $act_com;/*参与酒店：1代表所有酒店；2必须从参与酒店的关联表中查询*/
    public $time_add;/*添加时间*/
    public $time_edit;/*编辑时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_marketing_activity';
    }

    /**
     * @param mixed $parameters
     * @return WeMarketingActivity[]|WeMarketingActivity|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMarketingActivity|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}