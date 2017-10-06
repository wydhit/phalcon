<?php
define('APP_BEGIN_TIME', microtime(true));
define('APP_BEGIN_MEMORY', memory_get_usage());
/*这三个必须定义*/
define('PROJECT_PATH', dirname(__DIR__));//当前项目目录
define('ROOT_PATH', dirname(PROJECT_PATH));//总的根目录
define('COMMON_PATH', ROOT_PATH . '/common');//通用目录
define('PROJECT_NAMESPACE','Admin');
/*注册自动加载器*/
$loader = require COMMON_PATH . "/config/loader.php";
$loader->registerNamespaces([
    PROJECT_NAMESPACE => PROJECT_PATH
], true);

/*启动系统*/
/**
 * @var $bootstrap \Common\Core\Bootstrap
 */
$bootstrapClass='\\'.PROJECT_NAMESPACE.'\Bootstrap';
$bootstrap = new $bootstrapClass($loader);
$bootstrap->run();
