<?php

namespace Common\Models;

class WeHotelorder  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;/*用户id*/
    public $unick;/*用户昵称*/
    public $stimeint;/*提交时间（计算）*/
    public $stime;/*提交时间（显示）*/
    public $euid;/*编辑人（酒店、大平台）id*/
    public $eunick;/*编辑人（酒店、大平台）昵称*/
    public $etimeint;/*编辑时间（计算）*/
    public $etime;/*编辑时间（显示）*/
    public $isdel;/*是否删除，0=未删除，1=删除*/
    public $mydate1;/*入住时间*/
    public $mydate2;/*离店时间*/
    public $roomid;/*房型id*/
    public $roomname;/*房型名称*/
    public $hotelid;/*酒店id*/
    public $hotelname;/*酒店名称*/
    public $roomcount;/*每个定单的房间数*/
    public $allprice;/*总价*/
    public $favorprice;/*优惠价格*/
    public $payprice;/*优惠后价格*/
    public $guestinfo;/*客人信息*/
    public $actualprice;/*实际发生金额*/
    public $dofavorprice;/*最终使用优惠价*/
    public $everyprice;/*订单中每天的房价*/
    public $dayfavorprice;/*定单每天优惠价*/
    public $isspecial;/*0=未开通特价房，1=已开通特价房*/
    public $abiz;/*酒店实收金额*/
    public $guestmobile;/*用户电话号码*/
    public $guestmail;/*用户邮箱*/
    public $arrivetime1;/*最早到达时间*/
    public $arrivetime2;/*最晚到达时间*/
    public $mystatus;/*订单状态*/
    public $mystatusname;/*订单状态名称*/
    public $paytype;/*支付方式*/
    public $paytypename;/*支付方式名称*/
    public $payway;/*0余额1支付宝2微信*/
    public $ispayed;/*是否支付过 0=未付, 1=已付 2=已退款*/
    public $payid;/*支付id*/
    public $makingcard;/*正在制卡 =1 ,else=0*/
    public $makingtime;/*制卡,锁定定单的时间*/
    public $madecodelist;/*已出卡身份证列表,房号;*/
    public $livecount;/*入住量*/
    public $retrievingcard;/*正在回收卡*/
    public $retrievtime;/*回收卡的时间*/
    public $ismadecard;/*是否已出房卡*/
    public $roomcode;/*绑定的房号*/
    public $roomcodeid;/*预绑定房号id*/
    public $roomtitle;/*房间号*/
    public $islockcode;/*是否绑定房号*/
    public $iscontinuelive;/*0 代表未续住  1代表续住*/
    public $continuelivecode;/*续住码*/
    public $bywho;/*由自已提交的，还是代会员预定*/
    public $mydate1a;/*实际入住时间*/
    public $mydate2a;/*实际离店时间*/
    public $bizjudge;/*商家评价*/
    public $bizjudgetime;/*商家点评用户时间*/
    public $bizjudgetimeint;/*商家点评用户时间戳*/
    public $userjudge;/*用户是否做了评价*/
    public $judgedetail;/*差评原因*/
    public $isaccess;/*商家差评审核*/
    public $order_sources;/*定单来源*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_hotelorder';
    }

    /**
     * @param mixed $parameters
     * @return WeHotelorder[]|WeHotelorder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeHotelorder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}