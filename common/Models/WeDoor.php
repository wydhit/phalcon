<?php

namespace Common\Models;

use Phalcon\Validation\Validator\PresenceOf;

class WeDoor  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $title;/*几号门*/
    public $hasgoods;/*是否有商品，0无，1有*/
    public $mystatus;
    public $doorstatus;
    public $deviceid;/*设备id*/
    public $comgoodsid;/*酒店商品id*/
    public $goodsid;/*商品id*/
    public $comid;/*酒店id*/
    public $placeid;/*地点id*/
    public $ischange;/*是否换过货*/
    public $com_can_change_goods;/*店铺是否能更换柜门商品 0 不能 1 能*/
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
        return 'we_door';
    }

    /**
     * @param mixed $parameters
     * @return WeDoor[]|WeDoor|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeDoor|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}