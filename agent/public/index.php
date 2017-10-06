<?php
define('APP_BEGIN_TIME', microtime(true));
define('APP_BEGIN_MEMORY', memory_get_usage());
define('PROJECT_PATH', dirname(__DIR__));//当前项目目录
define('ROOT_PATH', dirname(PROJECT_PATH));//总的根目录
define('COMMON_PATH', ROOT_PATH . '/common');//通用目录

$loader = require COMMON_PATH . '/config/loader.php';
$loader->registerNamespaces(['Agent'=>PROJECT_PATH],true);

$app = new \Common\Core\Application();

$app->setAppDir(PROJECT_PATH);
$app->setAppNameSpace('Agent');

$app->run();
