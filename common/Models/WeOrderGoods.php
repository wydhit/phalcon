<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeOrderGoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $orderid;
    public $goodsid;
    public $comgoodsid;
    public $title;/*商品名*/
    public $price;/*各个商品价格*/
    public $counts;/*商品数量*/
    public $price_all;/*总价=单个商品价格*数量*/
    public $comid;/*店铺id*/
    public $preimg;/*预览图*/
    public $placeid;/*铺位id*/
    public $deviceid;/*设备id*/
    public $doorid;
    public $doortitle;/*门号*/
    public $door_num;/*房间号-店内有售录入*/
    public $order_type;/*订单类型：0表示格子机销售1表示店内销售*/
    public $commission;/*单商品佣金*/
    public $commission_all;/*店铺总佣金*/
    public $agent_commission;/*单个商品代理佣金*/
    public $agent_commission_all;/*代理总佣金*/
    public $plat_commission;/*单个商品平台佣金 */
    public $plat_commission_all;/*平台总佣金*/
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
        return 'we_ordergoods';
    }

    /**
     * @param mixed $parameters
     * @return WeOrderGoods[]|WeOrderGoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeOrderGoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}