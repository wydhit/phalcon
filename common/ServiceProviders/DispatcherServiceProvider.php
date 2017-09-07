<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:15
 */

namespace Common\ServiceProviders;

use \Phalcon\DiInterface;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model;

class DispatcherServiceProvider extends ServiceProvider
{

    protected $depends = [
        EventManagerServiceProvider::class
    ];

    public function register(DiInterface $di)
    {
        $di->setShared('dispatcher', function () use ($di) {
            $dispatcher = new Dispatcher();
            $dispatcher->setEventsManager($di->get('eventManager'));
            return $dispatcher;
        });

    }

}