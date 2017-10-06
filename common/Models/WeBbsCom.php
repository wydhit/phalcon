<?php

namespace Common\Models;

class WeBbsCom  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $title;/*标题*/
    public $content;/*内容*/
    public $uid;/*创建人*/
    public $stime;/*开始时间*/
    public $etime;/*修改时间*/
    public $endtime;/*结束时间*/
    public $issue_status;/*发布状态：0：未发布；1：已发布；2：已结束*/
    public $comlist;/*接受通知的酒店列表，‘all’：全部酒店*/
    public $level;/*重要程度  1:普通通知；2:重要通知；3:非常重要*/
    public $type;/*通知类别，update:系统更新*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_bbs_com';
    }

    /**
     * @param mixed $parameters
     * @return WeBbsCom[]|WeBbsCom|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeBbsCom|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}