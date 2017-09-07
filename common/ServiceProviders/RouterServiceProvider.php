<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:54
 */

namespace Common\ServiceProviders;

use Phalcon\Mvc\Router;
use Phalcon\DiInterface;

/**
 * 路由服务
 * Class RouterServiceProvider
 * @package common\ServiceProviders
 */
class RouterServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $di->setShared('router', function () {
            $router = new Router(false);
            $router->removeExtraSlashes(true);
            $router->setDefaultController('index');
            $router->setDefaultAction('index');
            return $router;
        });

    }

}