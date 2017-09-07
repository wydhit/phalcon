<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:33
 */

namespace Common\ServiceProviders;

use Common\Core\Cookies;

class CookieServiceProvider extends ServiceProvider
{
    public function register(\Phalcon\DiInterface $di)
    {
        $di->setShared('cookies', function () {
            $cookies = new Cookies();
            $cookies->setExpire(time() + 24 * 60 * 60);
            $cookies->useEncryption(true);
            return $cookies;
        }
        );

    }

}