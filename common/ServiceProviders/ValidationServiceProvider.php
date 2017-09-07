<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:20
 */

namespace Common\ServiceProviders;

use \Phalcon\DiInterface;
use Common\Core\BaseValidation;

class ValidationServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $di->setShared('validation', function () {
            return new BaseValidation();
        });
    }

}