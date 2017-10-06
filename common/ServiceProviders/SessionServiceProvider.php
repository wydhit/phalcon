<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:29
 */

namespace Common\ServiceProviders;

use Common\Helpers\Config;
use Common\Helpers\ConfigHelper;
use \Phalcon\DiInterface;
use Phalcon\Session\Adapter\Files as SessionAdapter;

class SessionServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {

        $di->setShared('session', function () {
            $sessionName =ConfigHelper::get('application.sessionName','mcSessionId');
            $session = new SessionAdapter();
            $session->setName($sessionName);
            $session->start();
            return $session;
        });
    }

}