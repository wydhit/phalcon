<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-11
 * Time: 14:15
 */

namespace Common\Core;

use Common\Exception\ValidationFailedException;
use Common\Helpers\StringHelper;
use Common\Models\BaseModel;
use Phalcon\Validation;
use Phalcon\Validation\Validator;


class BaseValidation extends Validation
{
    public $defaultMessages = [
        "Alnum" => "只能输入字母或者数字",
        "Alpha" => "只能输入字母",
        "Between" => "必须在 :min 到 :max 范围内",
        "Confirmation" => "必须和 :with 一致",
        "Digit" => "只能输入数字",
        "Email" => "请输入正确的Email地址",
        "ExclusionIn" => "不能是 :domain 中的一个",
        "FileEmpty" => "Field :field must not be empty",
        "FileIniSize" => "File :field exceeds the maximum file size",
        "FileMaxResolution" => "File :field must not exceed :max resolution",
        "FileMinResolution" => "File :field must be at least :min resolution",
        "FileSize" => "File :field exceeds the size of :max",
        "FileType" => "File :field must be of type: :types",
        "FileValid" => "Field :field is not valid",
        "Identical" => "Field :field does not have the expected value",
        "InclusionIn" => "必须是 :domain 中的一个",
        "Numericality" => "必须输入数字",
        "PresenceOf" => "必填项",
        "Regex" => "格式不支持",
        "TooLong" => "不能超过 :max 个字符",
        "TooShort" => "最少要输入 :min 个字符",
        "Uniqueness" => "重复！请重新输入",
        "Url" => "必须输入正确的url",
        "CreditCard" => "不可用的信用卡卡号",
        "Date" => "日期格式不正确"
    ];

    /**
     * @var $model BaseModel
     */
    protected $model = null;

    public function __construct(array $validators = null)
    {
        parent::__construct($validators);
        $this->setDefaultMessages($this->defaultMessages);
        $this->initialize();
    }

    public function initialize()
    {
    }


    /**
     * 为前端js获取验证规则
     * @return array
     */
    public function getRulesForJs()
    {

        $allValidators = $this->getValidators();
        $rules = [];
        foreach ($allValidators as $allValidator) {
            $title = $allValidator[0];
            if (!isset($rules[$title])) {
                $rules[$title] = [];
            }
            $rules[$title] = array_merge($rules[$title], $this->changeRules($allValidator[1]));
        }
        return $rules;
    }

    /*将phalcon的验证规则转成JQ validate 的*/
    private function changeRules(Validator $allValidator)
    {
        $rules = [];
        $validatorNames = explode('\\', get_class($allValidator));
        $validatorName = end($validatorNames);
        switch ($validatorName) {
            /*非空*/
            case 'PresenceOf':
                $rules['required'] = true;
                break;
            /*长短*/
            case 'StringLength':
                if ($allValidator->getOption('max')) {
                    $rules['maxlength'] = $allValidator->getOption('max');
                }
                if ($allValidator->getOption('min')) {
                    $rules['minlength'] = $allValidator->getOption('min');
                }
                break;
            /*email*/
            case 'Email':
                $rules['email'] = true;
                break;
            /*url:*/
            case 'Url':
                $rules['url'] = true;
                break;
            /*日期*/
            case 'Date':
                $rules['date'] = true;
                break;
            /*小数*/
            case 'Numericality':
                $rules['number'] = true;
                break;
            /*数字*/
            case 'Digit':
                $rules['digits'] = true;
                break;
            case 'Confirmation':
                if ($allValidator->getOption('with')) {
                    $rules['equalTo'] = '#' . $allValidator->getOption('with');
                }
                break;
            case 'Between':
                if ($allValidator->getOption('maximum') && $allValidator->getOption('minimum')) {
                    $rules['range'] = [$allValidator->getOption('minimum'), $allValidator->getOption('maximum')];
                }
                break;
        }
        return $rules;
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

    /**
     * 添加非空验证
     * @param $fields string|array
     * @param $option array
     */
    public function addPresenceOfRules($fields = '', $option = [])
    {
        $this->add($fields, new Validator\PresenceOf($option));
    }

    public function addIdRules($option = [])
    {
        $this->add('id', new Validator\PresenceOf($option));
    }

    public function addTitleRules($option = [])
    {
        $this->add('title', new Validator\PresenceOf($option));
    }

    /**
     * 验证并返回验证信息
     * @param array|object $data 要验证的数据
     * @param array $field 要验证哪些字段 为空则验证所有字段
     * @return \Phalcon\Validation\Message\Group
     */
    public static function valid($data = [], $field = [])
    {
        $v = new static();
        $res = $v->validate($data);
        if (!empty($field) && is_array($field)) {
            foreach ($field as $item) {
                if (isset($res[$item])) {
                    unset($res[$item]);
                }
            }
        }
        return $res;
    }

    /**
     * 验证不通过 直接抛出异常
     * @param array $data
     * @param array $field
     * @return  bool
     * @throws ValidationFailedException
     */
    public static function validWithException($data = [], $field = [])
    {
        $messages = self::valid($data, $field);
        if ($messages === true) {
            return true;
        } elseif ($messages === false) {
            throw new ValidationFailedException("未知验证错误");
        } else {
            $msg = $errorInput = [];
            foreach ($messages as $message) {
                $msg[] = $message->getMessage();
                $field=$message->getField();
                if(isset($errorInput[$field])){
                    $errorInput[$field] .= "\r\n".$message->getMessage();
                }else{
                    $errorInput[$field] = "\r\n".$message->getMessage();
                }
            }
        }
        if($msg){
            throw new ValidationFailedException(join("<br/>\r\n", $msg), [], $errorInput);
        }else{
            return true;
        }
    }

    /**
     *清除以前定义好的规则
     */
    public function clearRule()
    {
        $this->_validators = [];
        $this->_combinedFieldsValidators = [];
        $this->_filters = [];
    }


}