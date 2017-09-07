<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;


/**
 * Class WeOrder
 * @package Common\Models
 *
 */
class WeOrder  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $pay_code;/*支付单号-系统自动生成非重复码*/
    public $price_total;/*该订单商品总额*/
    public $service_price;/*服务费  店内售卖人员送货产生的费用*/
    public $commission_total;/*店铺佣金*/
    public $agent_commission_total;
    public $plat_commission_total;/*平台佣金*/
    public $gooids;/*商品id多个,分割*/
    public $comgoodsids;/*店铺商品id*/
    public $doorids;/*门号*/
    public $deviceid;/*设备id 一个订单只允许买一个设备内的*/
    public $placeid;/*地点id*/
    public $floor;/*楼层*/
    public $comid;/*酒店id*/
    public $door_num;/*房间号或者是送货地址-店内有售录入*/
    public $uid;/*用户id*/
    public $stime;/*创建订单时间 仅仅作为查看数据方便用*/
    public $stimeint;/*创建订单时间*/
    public $ispayed;/*是否支付*/
    public $payway;/*付款方式*/
    public $mystatus;/*订单状态*/
    public $mytype;/*定单类型，临时定单还是正式定单*/
    public $paytimeint;/*支付时间*/
    public $alllocker;/*所有门锁*/
    public $goodlocker;/*已打开的门锁*/
    public $badlocker;/*未打开的门锁*/
    public $doorstatus;/*门状态*/
    public $order_type;/*订单类型：0表示格子机销售1表示店内销售*/
    public $isdel;/*是否删除*/
    public $des;/*保存备注信息*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    const SHENDENG=0;
    const DIANNEI=1;
    const ORDER_TYPE_TIPS=[
        self::SHENDENG=>'神灯销售',
        self::DIANNEI=>'店内销售'
    ];
    /**
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public function getOrderTypeTips($key=null,$default=null)
    {
        if($this->order_type==WeOrder::SHENDENG){
            echo 'asdf';
        }
        if($key===null){
            $key=$this->order_type;
        }
        $all=self::ORDER_TYPE_TIPS;
        if (isset($all[$key])){
            return $all[$key];
        }elseif($default!==null){
            return $default;
        }else{
            return $key.'undefined';
        }
    }

    /**
     *字段验证规则 共模型插入时使用或者输入验证器使用
     */
    public static function rules()
    {

        return [
            /*'title'=>[
                'PresenceOf'=>new PresenceOf()
            ]*/
        ];
    }

    /*初始化*/
    public function initialize()
    {
        $this->hasMany('id',WeOrderGoods::class,'orderid',['alias'=>'gods']);
        $this->hasMany('id',WeOrderGoods::class,'orderid',['alias'=>'gods']);
       // $this->getOrderTypeTips();
    }

    /* 验证前的预置操作*/
    public function prepareSave()
    {

    }

    /**
     * 插入或者更新数据时验证 自动调取self::rules()方法返回的验证规则 其他特殊验证也可以写在这里  验证失败返回false即可
     * @return bool
     */
    public function validation()
    {
        $validator = $this->getDI()->get('validation');
        $allRule = self::rules();
        if (empty($allRule) || !is_array($allRule)) {
            return true;
        }
        foreach ($allRule as $k => $rules) {
            foreach ($rules as $rule) {
                $validator->add($k, $rule);
            }
        }
        return $this->validate($validator);
    }

    public function getSource()
    {
        return 'we_order';
    }

    /**
     * @param mixed $parameters
     * @return WeOrder[]|WeOrder|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrder|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}