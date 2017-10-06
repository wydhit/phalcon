<?php
/*需要注册的服务提供者*/
return [
    Common\ServiceProviders\DbServiceProvider::class,
    Common\ServiceProviders\EventManagerServiceProvider::class,
    Common\ServiceProviders\RouterServiceProvider::class,
    Common\ServiceProviders\UrlServiceProvider::class,
    Common\ServiceProviders\LoggerServiceProvider::class,
    Common\ServiceProviders\CacheServiceProvider::class,
    Common\ServiceProviders\DispatcherServiceProvider::class,
    Common\ServiceProviders\CryptServiceProvider::class
];