<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeCom  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;/*店铺ID*/
    public $ic;/*店铺编码*/
    public $title;/*店铺名称*/
    public $bizer_id;/*所属商家用户id*/
    public $agent_id;/*所属代理商id*/
    public $create_time;/*添加时间*/
    public $create_id;/*添加人id*/
    public $provinceid;/*所在省份(备用）*/
    public $cityid;/*所在城市ID（备用）*/
    public $mylocation;/*店铺详细地址*/
    public $teloffice;/*官方电话*/
    public $telfront;/*前台电话*/
    public $faxfront;/*传真*/
    public $preimg;/*店铺预览图*/
    public $logo;/*店铺LOGO*/
    public $readme;/*店铺简介*/
    public $cls;/*排序越大越靠前*/
    public $isdel;/*是否删除*/
    public $isrun;/*1运行 0 未运行*/
    public $islock;/*1锁定 0正常*/
    public $store_need_confirm;/*店铺商品调拨是否需要确认 1需要 0不需要*/
    public $dn_service_price;/*送货服务费*/
    public $dn_send_min_price;/*店内起送费用，订单金额不足的加dn_service_price*/
    public $dn_is_limit_time;/*是否开启送货上门时间限制*/
    public $dn_send_begin_time;/*送货上门开始时间*/
    public $dn_send_end_time;/*送货上门结束时间*/
    public $can_add_goods;/*能否增加自采商品*/
    public $add_goods_commission_p;/*自行增加商品 佣金百分比 单位%*/
    public $a_name;
    public $a_bank;
    public $a_number;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

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


}