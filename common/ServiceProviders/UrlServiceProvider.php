<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:58
 */

namespace Common\ServiceProviders;


use Common\Helpers\Config;
use Common\Helpers\ConfigHelper;
use \Phalcon\DiInterface;
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
        $di->setShared('url', function () {
            $url = new Url();
            $url->setBaseUri(ConfigHelper::get('application.baseUri', '/'));
            return $url;
        });

    }

}