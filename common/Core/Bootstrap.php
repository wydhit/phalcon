<?php

namespace Common\Core;

use Common\Exception\SerViceNoRunException;
use Common\Exception\ServiceRefuseException;
use Common\Helpers\DiHelper;
use Common\ServiceProviders\CacheServiceProvider;
use Common\ServiceProviders\CryptServiceProvider;
use Common\ServiceProviders\DbServiceProvider;
use Common\ServiceProviders\DispatcherServiceProvider;
use Common\ServiceProviders\EventManagerServiceProvider;
use Common\ServiceProviders\LoggerServiceProvider;
use Common\ServiceProviders\RouterServiceProvider;
use Common\ServiceProviders\UrlServiceProvider;
use Common\ServiceProviders\ValidationServiceProvider;
use Phalcon\Config;
use Phalcon\DiInterface;
use Phalcon\Loader;
use Phalcon\Mvc\Router\Group as RouterGroup;
use Phalcon\Mvc\Application;


class Bootstrap
{
    /**
     * @var $config Config;
     */
    public $config = null;
    /**
     * @var $loader \Phalcon\Loader
     */
    public $loader = null;
    /**
     * @var $di DiInterface
     */
    public $di = null;
    /**
     * @var $router \Phalcon\Mvc\Router
     */
    public $router;
    public $allModules = [];

    function __construct(Loader $loader)
    {
        /*设置默认时区*/
        date_default_timezone_set('Asia/Shanghai');
        ini_set('date.timezone', 'Asia/Shanghai');
        $this->loader = $loader;
        $this->config = $this->initConfig();/*初始化配置信息*/
        define('APP_DEBUG', $this->config->get('debug', false));
        /*异常处理器*/
        $this->registerExceptionHandle();
        /*注册服务*/
        $this->di = $this->registerService();
    }

    public function run()
    {
        /*系统启动检查*/
        $this->checkStart();
        $application = new Application($this->di);
        $application->setEventsManager($this->di->get('eventManager'));
        $application->useImplicitView(false);/*禁用自动视图*/
        $this->registerModule($application);
        $this->registerRouter($application);/*注册路由*/
        if (APP_DEBUG && $this->config->get('Debugbar', false)) {/*调试用的debug条*/
            $this->di['app'] = $application;
            (new \Snowair\Debugbar\ServiceProvider(COMMON_PATH . '/config/debugger_config.php'))->start();
        }
        $application->handle()->send();
    }

    /*系统初始化检查*/
    public function checkStart()
    {
        $userIp = $this->di->get('request')->getClientAddress();
        $banIp = $this->config->get('banIp')->toArray();
        /*检查ip是否被禁止*/
        if (in_array($userIp, $banIp)) {/*被禁ip*/
            throw new ServiceRefuseException('拒绝服务！');
        }
        /*检查系统是否关闭*/
        $whiteIp = $this->config->get('whiteIp')->toArray();
        if (!in_array($userIp, $whiteIp)) {
            if ($this->config->get('isRun') !== 1) {
                throw new ServiceNoRunException($this->config->get('noRunMessage', '服务维护中'));
            }
        }
    }

    /**
     * 注册路由
     * @param $application  Application
     */
    public function registerRouter($application)
    {
        $this->registerBaseRouter();/*注册基本路由*/
        $this->registerDirControllerRouter();/*注册控制器分层路由*/
        $this->registerModuleRouter($application);/*注册模块路由*/
        $this->registerOtherRouter();/*其他路由文件*/
    }

    /**注册基本路由*/
    public function registerBaseRouter()
    {
        /**
         * @var $router \Phalcon\Mvc\Router
         */
        $router = $this->di->get('router');
        $router->setDefaultNamespace(PROJECT_NAMESPACE . '\Controllers');
        /*默认路由*/
        $router->add('/', array(
            'controller' => 'index',
            'action' => 'index',
            'params' => ''
        ));
        $router->add('/:controller', array(
            'controller' => 1,
            'action' => 'index',
            'params' => ''
        ));
        $router->add('/:controller/:action/:params', array(
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ));
        $router->add('/:controller/:action/:params', array(
            'controller' => 1,
            'action' => 2,
            'params' => 3
        ));
        $router->notFound([
            'controller' => strtolower(PROJECT_NAMESPACE),
            'action' => 'notFound',
        ]);
    }

    public function registerDirControllerRouter()
    {
        //控制器分层需要在这里注册下目录 这是url地址出现的字符 为保持命名空间一致 实际目录应该首字母大写
        if (file_exists(PROJECT_PATH . '/config/dir_controller.php')) {
            /**
             * @var $router \Phalcon\Mvc\Router
             */
            $dirController = require PROJECT_PATH . '/config/dir_controller.php';
            /*控制器分层路由*/
            if (!empty($dirController) && is_array($dirController)) {
                $router = $this->di->get('router');
                foreach ($dirController as $value) {
                    if (!is_string($value)) {
                        continue;
                    }
                    $group = new RouterGroup([
                        'namespace' => __NAMESPACE__ . '\Controllers\\' . ucfirst($value),
                        'controller' => 'index',
                        'action' => 'index'
                    ]);
                    $group->setPrefix('/' . $value);
                    $group->add('', []);
                    $group->add('/:controller', ['controller' => 1]);
                    $group->add('/:controller/:action', ['controller' => 1, 'action' => 2]);
                    $group->add('/:controller/:action/:params', ['controller' => 1, 'action' => 2, 'params' => 3]);
                    $router->mount($group);
                    unset($group);
                }
            }
        }

    }

    /**
     * @param $application Application
     */
    public function registerModuleRouter($application)
    {
        $router = $this->di->get('router');
        /*多模块路由*/
        foreach ($application->getModules() as $key => $module) {
            $namespace = $module["namespace"];
            $router->add('/' . $key, array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 'index',
                'action' => 'index',
                'params' => ''
            ));
            $router->add('/' . $key . '/:controller', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 1,
                'action' => 'index',
                'params' => ''
            ));
            $router->add('/' . $key . '/:controller/:action/:params', array(
                'namespace' => $namespace,
                'module' => $key,
                'controller' => 1,
                'action' => 2,
                'params' => 3
            ));
        }

    }

    public function registerOtherRouter()
    {
        if (file_exists(PROJECT_PATH . '/config/router.php')) {
            include PROJECT_PATH . '/config/router.php';
        }

    }

    public function registerExceptionHandle()
    {
        /*注册错误处理*/
        $ExceptionHandler = new ExceptionHandler();
        $ExceptionHandler->setDebug(APP_DEBUG);
        $ExceptionHandler->listen();
    }

    /*注册模块*/
    public function registerModule(Application $application)
    {
        if (file_exists(PROJECT_PATH . '/config/modules.php')) {
            $allModules = require(PROJECT_PATH . '/config/modules.php');
            if ($allModules) {
                $application->registerModules($allModules);
            }
            unset($allModules);
        }
    }

    public function serviceProvider()
    {
        return [];
    }

    /*注册服务*/
    public function registerService()
    {
        $di = DiHelper::getDi();
        $di->setShared('config', $this->config);
        $di->setShared('loader', $this->loader);
        $services = [
            DbServiceProvider::class,
            EventManagerServiceProvider::class,
            RouterServiceProvider::class,
            UrlServiceProvider::class,
            LoggerServiceProvider::class,
            CacheServiceProvider::class,
            DispatcherServiceProvider::class,
            ValidationServiceProvider::class,
            CryptServiceProvider::class
        ];

        if ($this->serviceProvider()) {
            $services = array_merge($services, $this->serviceProvider());
        }
        foreach ($services as $service) {
            if (empty($service)) {
                continue;
            }
            $di->register(new $service($di));
        }
        $di->setInternalEventsManager($di->get('eventManager'));
        return $di;
    }

    /**
     * 初始化配置信息
     * 主要是加载配置文件
     * 包括公共配置文件和项目专用配置文件
     * @return Config
     */
    public function initConfig()
    {
        /*缓存配置文件*/
        $configCacheFile = PROJECT_PATH . '/config/config_cache.php';
        $isCacheConfig = false;/*是否启用配置缓存*/
        if ($isCacheConfig && file_exists($configCacheFile)) {
            $config = new Config(require $configCacheFile);
        } else {
            /**
             * @var $config Config;
             */
            /*公共配置文件*/
            $config = require COMMON_PATH . '/config/config.php';
            if (file_exists(COMMON_PATH . '/config/config.local.php')) {
                $config = $config->merge(require(COMMON_PATH . '/config/config.local.php'));
            }
            /*项目配置文件*/
            if (file_exists(PROJECT_PATH . '/config/config.php')) {
                $config->merge(require PROJECT_PATH . '/config/config.php');
            }
            if (file_exists(PROJECT_PATH . '/config/config.local.php')) {
                $config->merge(require(PROJECT_PATH . '/config/config.local.php'));
            }
            if ($isCacheConfig) {
                file_put_contents($configCacheFile, "<?php\r\n return " . var_export($config->toArray(), true) . ';');
            }
        }
        return $config;
    }
}