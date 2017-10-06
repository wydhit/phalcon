<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:25
 */

namespace Common\ServiceProviders;

use Common\Helpers\ConfigHelper;
use Phalcon\Mvc\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared('view', function () {
            $view = new View();
            $view->setViewsDir(ConfigHelper::get('application.viewsDir'));
            $view->registerEngines(['.phtml' => 'Phalcon\Mvc\View\Engine\Php']);
            return $view;
        });
    }

}