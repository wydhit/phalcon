<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:58
 */

namespace Common\ServiceProviders;


use \Phalcon\DiInterface ;
use Phalcon\Mvc\Url;

/**
 * Url
 * Class UrlServiceProvider
 * @package common\ServiceProviders
 */
class UrlServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {
        $config=$di->get('config');
        $di->setShared('url', function () use ($config) {
            $url = new Url();
            $url->setBaseUri($config->get('application')->get('baseUri','/'));
            return $url;
        });

    }

}