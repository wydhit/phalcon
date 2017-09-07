<?php
namespace Agent\Validator;


use Common\Core\BaseValidation;
use Common\Models\WeAdmin;
use Phalcon\Validation\Validator\PresenceOf;

class LoginValidator extends BaseValidation
{
    protected $model=WeAdmin::class;
    public function indexAction()
    {
        /*从模型添加验证规则*/
        $this->addRuleFromModel();
        /*自己添加验证规则*/
        /*$this->add('aa',new PresenceOf());*/
    }

    public function loginAction()
    {
        $this->addRuleFromModel('u_pass');
        $this->addRuleFromModel('u_name');
    }

}