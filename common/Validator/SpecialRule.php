<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-08
 * Time: 10:51
 */

namespace Common\Validator;

use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;


trait SpecialRule
{
    public function addLoginNameRules()
    {
        $this->add('u_name',new PresenceOf(['message'=>'用户名不能为空']));
        $this->add('u_name',new StringLength(['max'=>'50']));
    }

    public function addPassWordRule()
    {
        $this->add('u_pass',new PresenceOf(['message'=>'密码不能为空']));
        $this->add('u_pass',new StringLength(['min'=>'6','messageMinimum'=>'密码至少6位']));
    }

    /**
     * 添加非空验证
     * @param $fields string|array
     * @param $option array
     */
    public function addPresenceOfRules($fields = '', $option = [])
    {
        $this->add($fields, new PresenceOf($option));
    }



    public function addIdRules($option = [])
    {
        $this->add('id', new PresenceOf($option));
    }

    public function addTitleRules($option = [])
    {
        $this->add('title', new PresenceOf($option));
    }

    /**
     * 从模型里定义好的规则 增加验证规则 模型必须定义好 model::rules() 方法 返回规则数组
     * @param string $modelClass 模型类
     * @param string $field 字段名 为空则添加模型里定义好的所有规则
     * @param string $rule 规则名 为空则添加模型里定义好的某字段的所有规则
     * @return bool
     */
    public function addRuleFromModel($modelClass = '', $field = '', $rule = '')
    {
        $modelClass = empty($modelClass) ? $this->model : $modelClass;
        if (!class_exists($modelClass)) {
            return false;
        }
        $allRule = $modelClass::rules();
        return $this->addRuleFromArray($allRule, $field, $rule);
    }

    /**
     * 从数组添加验证规则
     * @param array $allRule
     *  $allRule=[
     *      'title'=>[
     *          'PresenceOf'=>new PresenceOf()
     *      ]
     * ]
     * @param string $field
     * @param string $rule
     * @return bool
     */
    public function addRuleFromArray($allRule = [], $field = '', $rule = '')
    {
        if (empty($allRule)) {
            return false;
        }
        if (empty($field)) {
            foreach ($allRule as $k => $v) {
                foreach ($v as $vs) {
                    $this->add($k, $vs);
                }
            }
        } elseif (empty($rule)) {
            if (isset($allRule[$field])) {
                foreach ($allRule[$field] as $value) {
                    $this->add($field, $value);
                }
            }
        } elseif (!empty($rule)) {
            if (isset($allRule[$field][$rule])) {
                $this->add($field, $allRule[$field][$rule]);
            }
        }
        return true;
    }

}