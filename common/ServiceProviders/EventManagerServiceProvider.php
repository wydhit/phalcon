<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:45
 */

namespace Common\ServiceProviders;

use Common\Event\DiEvent;
use Common\Event\DispatchEvent;
use Common\Helpers\ConfigHelper;
use Phalcon\Events\Manager as EventManager;

/*事件管理器*/

class EventManagerServiceProvider extends ServiceProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared('eventManager', function () {
            $eventManager = new EventManager();
            $events = ConfigHelper::get('event', [],true);
            if (!empty($events)) {
                foreach ($events as $name => $event) {
                    $eventManager->attach($name, new $event());
                }
            }
            return $eventManager;
        });
    }


}