<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeGoods  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;/*商品编号*/
    public $title;/*商品名称*/
    public $preimg;/*商品图片*/
    public $bigimg;/*大图片*/
    public $content;/*商品内容*/
    public $readme;/*商品简介*/
    public $com_id;/*店铺id代表是店铺添加的商品*/
    public $agent_id;/*代理商id*/
    public $isgroup;
    public $mygroup;/*组合品信息['id'=>'num']的json格式*/
    public $inventories;/*库存数量*/
    public $inventoriessum;/*总库存量*/
    public $inventoriesalarm;/*警戒库存*/
    public $salenum;/*销售量*/
    public $base_price;/*基准价（参考用不参与财务）*/
    public $isdel;/*是否删除*/
    public $class_id;/*分类id*/
    public $supply_id;/*供货商id*/
    public $belong;/*归属0平台 1 代理商 2 店铺*/
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
        return 'we_goods';
    }

    /**
     * @param mixed $parameters
     * @return WeGoods[]|WeGoods|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeGoods|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}