<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-01
 * Time: 16:47
 */

namespace Agent\Controllers\Validator;


use Common\Core\BaseValidation;
use Common\Models\WeUser;
use Phalcon\Validation\Validator\PresenceOf;

class LoginValidator extends BaseValidation
{
    public function initialize()
    {
        $this->add('login',new PresenceOf());
    }

//    public function LoginAction()
//    {
//        $this->clearRule();
//        $this->addRuleFromModel('','',WeUser::class);
//        $this->add('login',new PresenceOf());
//        $this->setFilters('title','string');
//    }
}