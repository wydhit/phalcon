<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:29
 */

namespace Common\ServiceProviders;

use \Phalcon\DiInterface;
use Phalcon\Session\Adapter\Files as SessionAdapter;

class SessionServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $sessionName = $di->get('config')->get('application')->get('sessionName', 'mcSessionId');
        $di->setShared('session', function () use ($sessionName) {
            $session = new SessionAdapter();
            $session->setName($sessionName);
            $session->start();
            return $session;
        });
    }

}