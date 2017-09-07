<?php
!defined('ROOT_PATH') && define('ROOT_PATH', dirname(dirname(__DIR__)));/*总的根目录*/
!defined('COMMON_PATH') && define('COMMON_PATH', dirname(__DIR__));/*公共目录*/
if (file_exists(ROOT_PATH . '/vendor/autoload.php')) {
    include(ROOT_PATH . '/vendor/autoload.php');
}
return (new \Phalcon\Loader())
    ->registerNamespaces([
        'Common' => COMMON_PATH
    ])->register();
