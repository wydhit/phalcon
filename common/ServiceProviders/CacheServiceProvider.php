<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:11
 */

namespace Common\ServiceProviders;


use Phalcon\DiInterface;
use Phalcon\Cache\Frontend\Data;
use Phalcon\Cache\Backend\File;

class CacheServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $config = $di->get('config');
        $di->setShared('cache', function () use ($config) {
            $frontCache = new Data(['lifetime' => '172800']);
            $cacheDir = $config->get('application')->cacheDir;
            $cache = new File($frontCache, ['cacheDir' => $cacheDir]);
            return $cache;
        });
    }

}