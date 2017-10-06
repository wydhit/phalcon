<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-08
 * Time: 17:22
 */

namespace Common\Validator;


use Common\Helpers\NumberHelper;
use Phalcon\Validation\Message;
use Phalcon\Validation\Validator;

class MobileValidator extends Validator
{
    public function validate(\Phalcon\Validation $validator, $attribute)
    {
       $value=$validator->getValue($attribute);
        if(!NumberHelper::validMobile($value)){
            $message = $this->getOption('message');

            if (!$message) {
                $message = '手机号格式错误';
            }
            $validator->appendMessage(
                new Message($message, $attribute, 'mobile')
            );
            return false;
        }
       return true;
    }


}