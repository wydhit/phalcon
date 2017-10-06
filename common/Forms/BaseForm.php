<?php
/*
 * 只初始化表单用
 * 验证 等逻辑处理在这里不处理
 *
 * 处理与用户交互
 * 1、添加新信息 并需要提交到数据库 如：添加用户 和model 紧密关联
 * 2、列表搜索表单 视图里直接tag输出 对于常用的比如时间选择 id 封装在CommonTags 里

*/

namespace Common\Forms;

use Common\Core\BaseValidation;
use Common\Exception\ModelNotFindException;
use Common\Exception\ValidationFailedException;
use Common\Helpers\StringHelper;
use Phalcon\Forms\ElementInterface;
use Phalcon\Forms\Form;
use Phalcon\Validation\Validator\PresenceOf;


class BaseForm extends Form
{

    private $modelLabel = [];
    public function initialize($entity = null, $userOptions)
    {
        if ($entity===null){
            $modelClass=$this->ModeClass();
        }else{
            $modelClass = get_class($entity);
        }

        $validation = new BaseValidation();
        if ($modelClass && class_exists($modelClass)) {/*如果存在模型 则把模型里的字段标签 引入到验证器里面去*/
            $validation->setLabels($modelClass::labels());
            /*将模型里的标签存起来*/
            $this->setModelLabel($modelClass::labels());
        }
        $this->setValidation($validation); /*指定验证器  */
    }

    public function ModeClass()
    {
        return '';
    }
    public function addFromModel($filed, $element, $model = '')
    {
        if (empty($model)) {
            $model = get_class($this->getEntity());
        }
        if (empty($model) || ! class_exists($model)) {
            throw new ModelNotFindException('表单模型不存在');
        }
        $elementObj = new $element($filed);
        $elementObj->setLabel($model::getLabel($filed))
            ->addValidators(
                $model::getRule($filed)
            );
        $this->add($elementObj);
    }

    /**/
    public function setModelLabel($labels = [])
    {
        $this->modelLabel = $labels;
    }

    public function getModelLabel()
    {
        return $this->modelLabel;
    }

    public function getModelOneLabel($field)
    {
        if (isset($this->modelLabel[$field])) {
            return $this->modelLabel[$field];
        } else {
            return '';
        }
    }


    /**
     * 基于ace模板解析一个字段元素 会默认加上很多东西 ，在视图里就可以少些一些东西
     * @param $name
     * @param null $attributes
     * @return string
     */
    public function renderAce($name, $attributes = null)
    {
        /**
         * @var $element ElementInterface
         */
        /*检查元素是否存在*/
        $element = isset($this->_elements[$name]) ? $this->_elements[$name] : '';
        if (empty($element)) {
            return "<h3>未找到表单元素<h3>";
        }
        if($element->getAttribute('banAceRender',0)==1){/*元素设置禁止ace解析 则直接解析*/
            return $element->render($attributes);
        }

        /*给元素增加一个class*/
        if (isset($attributes['class'])) {
            $attributes['class'] .= ' col-sm-12 ';
        } else {
            $attributes['class'] = ' col-sm-12 ';
        }

        /*解析元素*/
        $input = $element->render($attributes);

        /*特殊的元素后面想增加提示之类的文字 可以附带一个 afterInput 属性*/
        $afterInput = $element->getAttribute('afterInput', '');

        $name = $element->getName();/*元素名 也作为id用*/

        /*标签*/
        $label = $element->getLabel();/*元素默认标签*/
        if (empty($label)) {
            $label = $this->getModelOneLabel($name);/*当前form中的标签*/
        }
        $label = empty($label) ? $name : $label;/*都不存在就用name作为标签*/

        /*是不是必填项*/
        if ($this->elementIsRequired($element)) {
            $isRequiredHtml = '<small style="color:red;">*</small>';
        } else {
            $isRequiredHtml = '';
        }

        return '<div class="form-group"><label class="col-sm-2 control-label no-padding-right" for="' . $name . '">'
            . $label . $isRequiredHtml .
            '</label><div class="col-sm-5">'
            . $input . $afterInput .
            '</div></div>';
    }

    /**
     * 获取这个表单的验证规则转化成jq Validate的验证规则，用于前端验证
     */
    public function getValidatorJs()
    {
        $rules = [];
        $validation =$this->getValidation();
        $elements = $this->getElements();
        foreach ($elements as $element) {
            $validators = $element->getValidators();
            $name = $element->getName();
            foreach ($validators as $validator) {
                if (!isset($rules['rules'][$name])) {
                    $rules['rules'][$name] = [];
                    $rules['messages'][$name] = [];
                }
                $rules['rules'][$name] = array_merge($rules['rules'][$name], $validation->changeRules($validator,$name)['rules']);
                $rules['messages'][$name] = array_merge($rules['messages'][$name], $validation->changeRules($validator,$name)['messages']);
            }
        }
        return $rules;
    }


    public function isValidWithException($data = [], $entity = null)
    {
        $result = [];
        if (!$this->isValid($data, $entity)) {
            foreach ($this->getMessages() as $message) {
                if (!isset($result[$message->getField()])) {
                    $result[$message->getField()] = '';
                }
                $result[$message->getField()] .= " " . $message->getMessage();
            }
            throw new ValidationFailedException(join("<br/>\r\n", $result), [], $result);
        }
        return true;
    }


    /**
     * 是否是必填项
     * @param $element  ElementInterface
     * @return  bool
     */
    private function elementIsRequired($element)
    {
        foreach ($element->getValidators() as $validator) {
            if ($validator instanceof PresenceOf) {
                return true;
            }
        }
        return false;
    }

}