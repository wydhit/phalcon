<?php

namespace Common\Validator;

use Common\Core\BaseValidation;
use Phalcon\Validation\Validator\InclusionIn;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * 输入验证器模板
 * Class TempValidator
 * @package Common\Validator
 */
class TempValidator extends BaseValidation
{
    /**
     * 请在这里添加验证规则
     */
    protected $type = 'a';

    public function initialize()
    {
        if ($type = 'a') {
            $this->addRuleFromModel();/*从model定义好的添加*/
        }
        $this->addPresenceOfRules('title', ['message' => '标题不为空']);
        $this->add('title', new InclusionIn(['domain'=>['a','b']]));
        $this->addIdRules(['message' => 'id不得为空']);
    }



}