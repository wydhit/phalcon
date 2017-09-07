<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-11
 * Time: 10:47
 */

namespace Common\Traits;

use Common\Core\BaseValidation;
use Common\Exception\LogicException;
use Common\Helpers\ThrowHelper;
use Phalcon\Mvc\Model\ValidationFailed;
use \Common\Exception\ValidationFailedException;

Trait  ControllerValid
{
    use BaseTrait;
    public function getValidationRulesForJs($validationClass = null, $actionName = null)
    {
        $validationClass = $this->getValidationName($validationClass);
        $actionName=$this->getValidationActionName($actionName);
        if(!class_exists($validationClass)){
         return [];
        }
        /**
         * @var $result \Phalcon\Validation\Message\Group
         * @var $validator BaseValidation
         */
        $validator = new $validationClass();
        if (method_exists($validator,$actionName)){
            $validator->{$actionName}();
        }

        return $validator->getRulesForJs();
    }

    /**
     * 自动寻找验证器 并验证输入 如果通过验证则返回true  不通过则抛出异常
     * @param $input
     * @param string $validatorName
     * @throws LogicException
     * @return true
     */
    public function validationInput($input=[], $validationClass=null,$actionName = null)
    {
        if(empty($input)){
            $input=$this->request->get();
        }
        $validationClass = $this->getValidationName($validationClass);
        $actionName=$this->getValidationActionName($actionName);
        if(!class_exists($validationClass)){
            return true;
        }
        /**
         * @var $result \Phalcon\Validation\Message\Group
         * @var $validator \Phalcon\Validation
         */
        $validator = new $validationClass();
        if (method_exists($validator,$actionName)){
            $validator->{$actionName}();
        }

        $result = $validator->validate($input);
        $message = [];
        if (count($result)) {
            foreach ($result as $item) {
                $field = $item->getField();
                if (isset($message[$field])) {
                    $message[$field] .= $item->getMessage() . "\r\n";
                } else {
                    $message[$field] = $item->getMessage();
                }
            }
        }
        ThrowHelper::ThrowIfNotEmpty($message,'',new ValidationFailedException('输入有误',[],$message));
        return true;
    }
    /**
     * 自动寻找验证器
     * @param null $controllerName
     * @param null $actionName
     * @return string
     */
    private function getValidationName($validatorName = null)
    {

        if(empty($validatorName)){
            $validatorName = $this->dispatcher->getControllerClass();
            $validatorName = str_replace('\Controllers', '\Validator', $validatorName);
            $validatorName = str_replace('Controller', 'Validator', $validatorName);
        }
        if (class_exists($validatorName)) {
            return $validatorName;
        } else {
            return '';
        }
    }
    private function getValidationActionName($actionName=null)
    {
        if($actionName===null){
            return $this->dispatcher->getActionName().'Action';
        }else{
            return trim($actionName).'Action';
        }
    }


}