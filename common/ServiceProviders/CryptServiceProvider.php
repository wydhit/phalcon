<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:05
 */

namespace Common\ServiceProviders;

use \Phalcon\DiInterface;
use Phalcon\Crypt;

/**
 * 加密解密
 * Class CryptServiceProvider
 * @package common\ServiceProviders
 */
class CryptServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $di->setShared('crypt', function () {
            $crypt = new Crypt();
            $crypt->setKey('%3171e$i86e$f!8ja1');
            return $crypt;
        });
    }

}