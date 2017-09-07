<?php
return new \Phalcon\Config([
    'database' => [
        'adapter' => '\Common\Db\Mysql',
        'host' => '192.168.0.22',
        'username' => 'root',
        'password' => 'root123',
        'dbname' => 'magiclamp',
        'charset' => 'utf8',
    ],
    'debug' => true,
    'Debugbar'=>true,
    'isRun'=>1,/*1为正常开启 0 为升级调试等原因系统关闭关闭后所有功能都不能使用*/
    'noRunMessage'=>'系统升级中...请于11:30后使用，给您造成的不便请谅解',/*系统关闭时给出的提示*/
    'whiteIp'=>['127.0.0.1','111.160.198.250'],/*系统关闭后仍可以正常使用的ip*/
    'banIp'=>[],/*任何情况下都禁止使用系统的黑名单*/
]);
