<?php

namespace Common\Models;

class WeCom  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*酒店ID*/
    public $ic;/*酒店ic*/
    public $uid;
    public $u_nick;/*酒店名称*/
    public $u_name;
    public $a_name;
    public $a_bank;
    public $a_number;
    public $stimeint;/*入住时间*/
    public $suid;
    public $snick;
    public $etime;/*离店时间*/
    public $euid;
    public $enick;
    public $title;/*酒店名字*/
    public $title_en;
    public $provinceid;
    public $cityid;/*城市ID*/
    public $districtid;
    public $bizareaid;
    public $provincename;/*省*/
    public $cityname;/*市*/
    public $districtname;/*区*/
    public $bizareaname;/*商圈*/
    public $zipcode;/*邮编*/
    public $weburl;
    public $telareacode;
    public $teloffice;
    public $telfront;
    public $faxfront;
    public $dateopen;
    public $countroom;
    public $storey1;
    public $storey2;
    public $belongcom;
    public $isforeign;
    public $star1;
    public $datestar;
    public $star2;
    public $star2name;
    public $otherpay;
    public $payname;
    public $paycount;
    public $iscard;
    public $paycard;
    public $paycardname;
    public $longitude;/*经度*/
    public $latitude;
    public $preimg;
    public $readme;
    public $mylocation;
    public $serverbase;
    public $serverbasename;
    public $serverother;
    public $servermetting;
    public $serverbar;
    public $serverfun;
    public $serverfunname;
    public $img1;
    public $img2;
    public $img3;
    public $backmoney;
    public $arrivetime1;/*最早到店时间*/
    public $arrivetime2;/*最晚到店时间*/
    public $isopen;
    public $isauto;
    public $isgood;
    public $isseted;/*是否进行了参数设置*/
    public $delaytime1;/*延迟退房加收房费时间段开始时间*/
    public $delaytime2;/*延迟退房加收房费时间段结束时间*/
    public $delaypercent;/*延迟退房加收房费百分比*/
    public $delay100time;/*延迟退房加收整日房费超时时间点*/
    public $noshowpercent;/*预付未到客人扣费百分比*/
    public $mylogo;/*酒店LOGO*/
    public $telorder;/*订房热线*/
    public $adateperiod;/*账期*/
    public $commission;/*每间房佣金*/
    public $isstand;/*是否标准制定单位*/
    public $hits;/*点击量*/
    public $cls;/*排序*/
    public $isdelhotel;/*是否删除*/
    public $is_display;/*是否是演示酒店*/
    public $scores;/*酒店评分*/
    public $recommends;/*值得推荐*/
    public $isrun;
    public $islock;
    public $store_need_confirm;/*店铺商品调拨是否需要确认 1需要 0不需要*/
    public $dn_service_price;/*送货服务费*/
    public $dn_send_min_price;/*店内起送费用，订单金额不足的加dn_service_price*/
    public $dn_is_limit_time;/*是否开启送货上门时间限制*/
    public $dn_send_begin_time;/*送货上门开始时间*/
    public $dn_send_end_time;/*送货上门结束时间*/
    public $can_add_goods;/*能否增加自采商品*/
    public $add_goods_commission_p;/*自行增加商品 佣金百分比 单位%*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    const isRunAllType=[
        1=>'运行',
        0=>'未运行'
    ];

    public static function getRunTips($type)
    {
        $all=self::isRunAllType;
        if(isset($all[$type])){
            return $all[$type];
        }else{
            return '未知';
        }
    }
    const isLockAllType=[
        1=>'锁定',
        0=>'未锁定'
    ];
    public static function getLockTips($type)
    {
        $all=self::isLockAllType;
        if(isset($all[$type])){
            return $all[$type];
        }else{
            return '未知';
        }
    }


    public function getSource()
    {
        return 'we_com';
    }

    /**
     * @param mixed $parameters
     * @return WeCom[]|WeCom|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCom|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }

    /*获取一个商家用户下属的店铺id*/
    public static function getComidsBySysBizerId($sysBizerId=0)
    {
        $res=[];
        foreach (self::find(['uid=:uid:','bind'=>['uid'=>$sysBizerId]]) as $item) {
              $res[]=$item->id;
        }
        return $res;
    }




}