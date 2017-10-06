<?php

namespace Common\Models;

class WeActivity  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $act_title;/*活动标题*/
    public $act_img;
    public $act_desc;/*活动说明*/
    public $status;/*状态：1保存草稿；2开启；3关闭；*/
    public $time_start;/*开始时间*/
    public $time_end;/*结束时间*/
    public $is_allcom;/*是否所有酒店都参加：1否；2是*/
    public $send_money;/*赠款数额 单位为 分*/
    public $send_act;/*赠款环节 目前有的就是 1 注册 2 购买生成订单 3 购买支付之后*/
    public $time_instert;/*插入时间*/
    public $time_edit;/*编辑时间*/
    public $send_money_to_channel;/*给渠道商的赠款*/
    public $act_type;/*活动类型：注册活动-1；现货促销：-2；预定商品-3；*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_activity';
    }

    /**
     * @param mixed $parameters
     * @return WeActivity[]|WeActivity|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeActivity|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}