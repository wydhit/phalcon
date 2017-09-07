<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:25
 */

namespace Common\ServiceProviders;

use Phalcon\Mvc\View;

class ViewServiceProvider extends ServiceProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $config = $di->get('config');
        $di->setShared('view', function () use ($config) {
            $view = new View();
            $view->setViewsDir($config->get('application')->get('viewsDir'));
            $view->registerEngines(['.phtml' => 'Phalcon\Mvc\View\Engine\Php']);
            return $view;
        });
    }

}