<?php
/**
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 * 这仅仅是一个示例文件  要想起作用 需要复制到项目config文件夹下！！！！！！！！！
 * !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
 */
/**
 *
 * @var $router \Phalcon\Mvc\Router
 */
$router=\Common\Helpers\DiHelper::getDi()->get('router');

$router->add('/XXXX','Index::index');