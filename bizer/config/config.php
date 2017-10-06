<?php
return new Phalcon\Config([
    'debug' => true,/*调试模式 调试模式将暴露更多错误信息*/
    'Debugbar'=>true,/*是否启用Debugbar*/
    'application' => [
        'allowDomain' => '',/*域名 只有该域名及子域名才能访问 尚未实现的功能*/
        'assetUri' => 'http://static.e.com/',/*js css 等资源网址*/
        'baseUri' => '/',/*基础网址 自动生成url时 自动加上这个*/
        'projectDir' => PROJECT_PATH,
        'cacheDir' => PROJECT_PATH . '/cache',
        'logDir' => PROJECT_PATH . '/logs',
        'viewsDir' => PROJECT_PATH . '/views',
    ]
]);

