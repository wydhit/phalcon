<?php

namespace Admin;

use Phalcon\Loader;
use Common\ServiceProviders\CookieServiceProvider;
use Common\Core\Bootstrap as BaseBootstrap;
use Common\ServiceProviders\ViewServiceProvider;
use Common\ServiceProviders\SessionServiceProvider;

class Bootstrap extends BaseBootstrap
{
    function __construct(Loader $loader)
    {
        parent::__construct($loader);
    }
}

