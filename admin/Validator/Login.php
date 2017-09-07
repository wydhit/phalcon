<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-15
 * Time: 15:06
 */

namespace admin\Validator;


use Common\Core\BaseValidation;
use Common\Models\WeUser;

class Login extends BaseValidation
{
    protected $model=WeUser::class;
    public function indexAction()
    {
    }

    public function loginAction()
    {
        $this->indexAction();

    }

}