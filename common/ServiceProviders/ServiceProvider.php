<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:41
 */

namespace Common\ServiceProviders;


use Phalcon\Di;
use Phalcon\Di\ServiceProviderInterface;
use Phalcon\DiInterface;

/**
 * 服务提供者基类 注册最基本的服务
 * Class ServiceProvider
 * @package common\ServiceProviders
 */
class ServiceProvider implements ServiceProviderInterface
{
    protected $depends = [];
    private static $registered = [];

    public function __construct(DiInterface $di)
    {
        $this->resolveDepend($di);
        self::$registered[] = static::class;
    }


    /**
     * @param Di $di
     */
    public function resolveDepend(DiInterface $di)
    {
        if (!empty($this->depends)) {
            foreach ($this->depends as $depend) {
                if (!in_array($depend, self::$registered)) {
                    $depend='\\'.$depend;
                    $di->register(new $depend($di));
                    self::$registered[] = $depend;
                }
            }
        }
    }

    public function register(\Phalcon\DiInterface $di)
    {

    }

}