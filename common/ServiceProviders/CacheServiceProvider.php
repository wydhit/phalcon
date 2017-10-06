<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:11
 */

namespace Common\ServiceProviders;


use Common\Helpers\Config;
use Common\Helpers\ConfigHelper;
use Phalcon\DiInterface;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend\File;

class CacheServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {

        $di->setShared('cache', function () {
            $frontCache = new Data(['lifetime' => '172800']);
            $cacheDir = ConfigHelper::get('application.cacheDir');
            $cache = new File($frontCache, ['cacheDir' => $cacheDir]);
            return $cache;
        });
    }

}