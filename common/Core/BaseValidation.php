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
use Common\Validator\SpecialRule;
use Phalcon\Validation;
use Phalcon\Validation\Validator;


class BaseValidation extends Validation
{
    use SpecialRule;
    public $defaultMessages = [
        "Alnum" => ":field 只能输入字母或者数字",
        "Alpha" => ":field 只能输入字母",
        "Between" => ":field 必须在 :min 到 :max 范围内",
        "Confirmation" => ":field 必须和 :with 一致",
        "Digit" => ":field 只能输入数字",
        "Email" => ":field 必须是正确的Email地址",
        "ExclusionIn" => ":field  不能是 :domain 中的一个",
        "FileEmpty" => " :field 不能为空",
        "FileIniSize" => "File :field exceeds the maximum file size",
        "FileMaxResolution" => "File :field must not exceed :max resolution",
        "FileMinResolution" => "File :field must be at least :min resolution",
        "FileSize" => "File :field exceeds the size of :max",
        "FileType" => "File :field must be of type: :types",
        "FileValid" => "Field :field is not valid",
        "Identical" => " :field 不正确",
        "InclusionIn" => ":field 必须是 :domain 中的一个",
        "Numericality" => ":field 必须输入数字",
        "PresenceOf" => ":field 是必填项",
        "Regex" => ":field 格式不支持",
        "TooLong" => ":field 不能超过 :max 个字符",
        "TooShort" => ":field 最少要输入 :min 个字符",
        "Uniqueness" => ":field 重复！请重新输入",
        "Url" => ":field 必须是正确的url",
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
    }

    public function initialize()
    {

    }

    /**
     * 为前端js获取验证规则
     * @return array
     */
    public static function getRulesForJs()
    {
        $validate = new static();
        $allValidators = $validate->getValidators();
        $rules = [];
        foreach ($allValidators as $allValidator) {
            $title = $allValidator[0];
            if (!isset($rules[$title])) {
                $rules[$title] = [];
            }
            $rules[$title] = array_merge($rules[$title], $validate->changeRules($allValidator[1])['rules']);
        }
        return $rules;
    }

    /**
     * 验证并返回验证信息
     * @param array|object $data 要验证的数据
     * @param array $field 要验证哪些字段 为空则验证所有字段
     * @return \Phalcon\Validation\Message\Group
     */
    public static function valid($data = [], $onlyField = [])
    {
        $validate = new static();
        $validate->cancelExceptField($onlyField);
        return $validate->validate($data);
    }

    /**
     * 验证不通过 直接抛出异常
     * @param array $data
     * @param array $field
     * @return  bool
     * @throws ValidationFailedException
     */
    public static function validWithException($data = [], $onlyField = [])
    {
        $messages = self::valid($data, $onlyField);
        if ($messages === true) {
            return true;
        } elseif ($messages === false) {
            throw new ValidationFailedException("未知验证错误");
        } else {
            $msg = $errorInput = [];
            foreach ($messages as $message) {
                $msg[] = $message->getMessage();
                $field = $message->getField();
                if (isset($errorInput[$field])) {
                    $errorInput[$field] .= "\r\n" . $message->getMessage();
                } else {
                    $errorInput[$field] = "\r\n" . $message->getMessage();
                }
            }
        }
        if ($msg) {
            throw new ValidationFailedException(join("<br/>\r\n", $msg), [], $errorInput);
        } else {
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

    /**
     * 除了这些字段 取消其他字段的验证
     * @param $field
     */
    public function cancelExceptField($field)
    {
        if (empty($field)) {
            return;
        }
        foreach ($this->_validators as $k => $validator) {
            if (!in_array($validator[0], $field)) {
                unset($this->_validators[$k]);
            }
        }
    }

    /**
     * 将phalcon的验证规则转成JQ validate 的验证规则
     * @param Validation\ValidatorInterface $validator
     * @return array
     */
    public function changeRules($validator,$name='')
    {
        $rules = [];
        $messages = [];
        $validatorName = get_class($validator);
        switch ($validatorName) {
            /*非空*/
            case 'Phalcon\Validation\Validator\PresenceOf':
                $rules['required'] = true;
                $messages['required'] = $this->getValidatorMessage($name,$validator);
                break;
            /*长短*/
            case 'Phalcon\Validation\Validator\StringLength':
                if ($validator->getOption('max')) {
                    $rules['maxlength'] = $validator->getOption('max');
                    $thisMessage = $this->getValidatorMessage($name,$validator, 'TooLong', 'messageMaximum');
                    $replacePairs = [":field" => $validator->getOption('label', ''), ":max" => $validator->getOption('max')];
                    $messages['maxlength'] = strtr($thisMessage, $replacePairs);
                }
                if ($validator->getOption('min')) {
                    $rules['minlength'] = $validator->getOption('min');
                    $thisMessage = $this->getValidatorMessage($name,$validator, 'TooShort', 'messageMinimum');
                    $replacePairs = [":field" => $validator->getOption('label', ''), ":min" => $validator->getOption('min')];
                    $messages['minlength'] = strtr($thisMessage, $replacePairs);
                }
                break;
            /*email*/
            case 'Phalcon\Validation\Validator\Email':
                $rules['email'] = true;
                $messages['email'] = $this->getValidatorMessage($name,$validator);;
                break;
            /*url:*/
            case 'Phalcon\Validation\Validator\Url':
                $rules['url'] = true;
                $messages['url'] = $this->getValidatorMessage($name,$validator);;
                break;
            /*日期*/
            case 'Phalcon\Validation\Validator\Date':
                $rules['date'] = true;
                $messages['date'] = $this->getValidatorMessage($name,$validator);;
                break;
            /*小数*/
            case 'Phalcon\Validation\Validator\Numericality':
                $rules['number'] = true;
                $messages['number'] = $this->getValidatorMessage($name,$validator);;
                break;
            /*数字*/
            case 'Phalcon\Validation\Validator\Digit':
                $rules['digits'] = true;
                $messages['digits'] = $this->getValidatorMessage($name,$validator);;
                break;
            case 'Phalcon\Validation\Validator\Confirmation':
                if ($validator->getOption('with')) {
                    $rules['equalTo'] = '#' . $validator->getOption('with');
                    $messages['equalTo'] = $this->getValidatorMessage($name,$validator);;
                }
                break;
            case 'Phalcon\Validation\Validator\Between':
                if ($validator->getOption('maximum') && $validator->getOption('minimum')) {
                    $rules['range'] = [$validator->getOption('minimum'), $validator->getOption('maximum')];
                    $thisMessage = $this->getValidatorMessage($name,$validator);
                    $replacePairs = [":min" => $validator->getOption('min'), ":max" => $validator->getOption('max')];
                    $messages['range'] = strtr($thisMessage, $replacePairs);
                }
                break;
        }
        return compact('rules', 'messages');
    }

    /**
     * 获取一个验证的验证错误信息
     * @param Validation\ValidatorInterface $validator
     * @param string $type
     * @param string $messageField
     * @return mixed|string
     */
    public function getValidatorMessage($name='',$validator, $type = '', $messageField = 'message')
    {

        $message = $validator->getOption($messageField);
        if (empty($message)) {
            if (empty($type)) {
                $validatorClassName = get_class($validator);
                $type = substr($validatorClassName, strripos($validatorClassName, '\\'));
                $type = trim($type, '\\');
            }
            $message = $this->getDefaultMessage($type);
            $label=$validator->getOption('label', '');
            if(empty($label)){
                $label=$this->getLabel($name);
            }
            $replacePairs = [":field" =>$label ];
            $message = strtr($message, $replacePairs);
        }
        return $message;
    }


}