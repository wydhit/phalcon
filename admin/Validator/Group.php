<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-16
 * Time: 8:34
 */

namespace Admin\Validator;


use Common\Core\BaseValidation;
use Common\Models\WeGroup;

class Group extends BaseValidation
{
    protected $model=WeGroup::class;
    public function editAction()
    {
        $this->addRuleFromModel();
    }

    public function addAction()
    {
        $this->addRule();
    }

    public function addRoleAction()
    {
        $this->addRule();
        
    }

}