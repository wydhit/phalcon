<?php

namespace Common\Core;

use Common\Helpers\ConfigHelper;
use Common\Helpers\DiHelper;
use Common\Helpers\ThrowHelper;
use Phalcon\Di;
use Phalcon\Http\ResponseInterface;
use Phalcon\Mvc\Router\Group as RouterGroup;
use \Phalcon\Mvc\Application as PhalconApplication;

/**
 * 调试用的
 * Class Application
 * @package Common\Core
 */
class Application extends PhalconApplication
{
    private $appDir = '';
    private $appNameSpace = '';


    public function __construct()
    {
        date_default_timezone_set('Asia/Shanghai');
        ini_set('date.timezone', 'Asia/Shanghai');
        parent::__construct(DiHelper::getDi());
        $this->useImplicitView(false);
    }

    public function getAppDir()
    {
        return $this->appDir;
    }

    public function setAppDir($appDir)
    {
        $this->appDir = $appDir;
    }

    public function getAppNameSpace()
    {
        return $this->appNameSpace;
    }

    public function setAppNameSpace($appSpace)
    {
        $this->appNameSpace = $appSpace;
    }

    public function run()
    {

        $this->initConfig();/*初始化配置信息*/
        $this->registerExceptionHandle();/*注册异常处理*/
        $this->registerService();/*注册服务*/

        $this->setEventsManager($this->getDI()->get("eventManager"));/*设置事件管理*/
        $this->getEventsManager()->fire("application:checkStart", $this);/*系统启动前检查*/

        $this->registerModule();/*注册模块*/
        $this->registerRouter();/*注册路由*/

        $this->getEventsManager()->fire("application:beforeHandle", $this);
        $response = $this->handle();/*处理请求*/
        $this->getEventsManager()->fire("application:afterHandle", $this);
        $response->send();/*发送响应*/
        $this->getEventsManager()->fire("application:afterSend", $this);
    }

    /*注册模块*/
    public function registerModule()
    {
        if (file_exists($this->appDir . '/config/modules.php')) {
            $allModules = require($this->appDir . '/config/modules.php');
            if (!empty($allModules) && is_array($allModules)) {
                $this->registerModules($allModules);
            }
        }
    }

    public function registerRouter()
    {
        $this->registerBaseRouter();/*注册基本路由*/
        $this->registerDirControllerRouter();/*注册控制器分层路由*/
        $this->registerModuleRouter();/*注册模块路由*/
        $this->registerOtherRouter();/*其他路由文件*/
    }

    /**注册基本路由*/
    private function registerBaseRouter()
    {
        /**
         * @var $router \Phalcon\Mvc\Router
         */
        $router = $this->getDI()->getShared('router');

        $router->setDefaultNamespace($this->appNameSpace . '\Controllers');
        $router->setDefaultController('index');
        $router->setDefaultAction('index');
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
            'controller' => strtolower($this->appNameSpace),
            'action' => 'notFound',
        ]);
    }

    private function registerDirControllerRouter()
    {
        //控制器分层需要在这里注册下目录 这是url地址出现的字符 为保持命名空间一致 实际目录应该首字母大写
        if (file_exists($this->appDir . '/config/dir_controller.php')) {
            /**
             * @var $router \Phalcon\Mvc\Router
             */
            $dirController = require $this->appDir . '/config/dir_controller.php';
            /*控制器分层路由*/
            if (!empty($dirController) && is_array($dirController)) {
                $router = $this->getDI()->get('router');
                foreach ($dirController as $value) {
                    if (!is_string($value)) {
                        continue;
                    }
                    $group = new RouterGroup([
                        'namespace' => $this->appNameSpace . '\Controllers\\' . ucfirst($value),
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
    private function registerModuleRouter()
    {
        $router = $this->getDI()->get('router');
        /*多模块路由*/
        foreach ($this->getModules() as $key => $module) {
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

    private function registerOtherRouter()
    {
        if (file_exists($this->appDir . '/config/router.php')) {
            include $this->appDir . '/config/router.php';
        }
    }

    /**
     *初始化配置文件
     * 1.公共配置文件  common/config.php  所有项目通用的配置文件
     */
    private function initConfig()
    {
        /*缓存配置文件*/
        $configCacheFile = $this->appDir . '/config/config.cache.php';
        $isCacheConfig = true;/*是否启用配置缓存*/
        if (file_exists($configCacheFile)) {
            $config = new \Phalcon\Config(require $configCacheFile);
        } else {
            /**
             * @var $config \Phalcon\Config;
             */
            /*公共配置文件*/
            $config = require COMMON_PATH . '/config/config.php';
            if (file_exists(COMMON_PATH . '/config/config.local.php')) {
                $config->merge(require COMMON_PATH . '/config/config.local.php');
            }
            /*项目配置文件*/
            if (file_exists($this->appDir . '/config/config.php')) {
                $config->merge(require $this->appDir . '/config/config.php');
            }
            if (file_exists($this->appDir . '/config/config.local.php')) {
                $config->merge(require($this->appDir . '/config/config.local.php'));
            }
            if ($isCacheConfig) {
                file_put_contents($configCacheFile, "<?php\r\n return " . var_export($config->toArray(), true) . ';');
            }
        }
        $this->getDI()->setShared("config", $config);
    }

    public function registerExceptionHandle()
    {
        /*注册错误处理*/
        (new ExceptionHandler())->listen();
    }

    public function registerService()
    {
        /**
         * @var  $di Di
         */
        $di = $this->getDI();
        $serviceProviders = require(COMMON_PATH . "/config/serviceProvider.php");
        if (file_exists($this->appDir . '/config/serviceProvider.php')) {
            $serviceProviders = array_merge($serviceProviders, require($this->appDir . '/config/serviceProvider.php'));
        }
        foreach ($serviceProviders as $serviceProvider) {
            if (empty($serviceProvider)) {
                continue;
            }
            $di->register(new $serviceProvider($di));
        }
        $di->setInternalEventsManager($di->get('eventManager'));
    }

    /*调试用*/
    public function handleX($uri = null)
    {
        $di = $this->getDI();
        /**
         * @var $router \Phalcon\Mvc\Router
         */
        $router = $di->get('router');
        $router->handle($uri);
        $matchedRoute = $router->getMatchedRoute();
        echo '<pre>';


        if (gettype($matchedRoute) === 'object') {
            $match = $matchedRoute->getMatch();
            if ($match !== null) {
                $possibleResponse = call_user_func_array($match, $router->getParams());
                if (is_string($possibleResponse)) {
                    $response = $di->get('response');
                    $response->setContent($possibleResponse);
                    return $response;
                } elseif (gettype($possibleResponse) === 'object' && $possibleResponse instanceof ResponseInterface) {
                    $possibleResponse->sendHeaders();
                    $possibleResponse->sendCookies();
                    return $possibleResponse;
                }
            }
        }

        $moduleName = $router->getModuleName();
        $moduleName = empty($moduleName) ? $this->_defaultModule : $moduleName;
        $moduleObject = null;
        if ($moduleName) {
            $module = $this->getModule($moduleName);
            if (is_array($module)) {
                $className = isset($module['className']) ? $module['className'] : 'Module';
                if ($path = isset($module['path']) ? $module['path'] : '') {
                    if (!class_exists($className)) {
                        ThrowHelper::ThrowIf(!file_exists($path), '', new \Exception("Module path'" . $path . "'doesn't exist"));
                        require $path;
                    }
                }

                $moduleObject = $di->get($className);
                $moduleObject->registerAutoloaders($di);
                $moduleObject->registerServices($di);
            } else {
                if (!($module instanceof \Closure)) {
                    throw new \Exception("Invalid module definition");
                }
                $moduleObject = call_user_func_array($module, [$di]);
            }
        }

        $dispatcher = $di->get('dispatcher');
        $dispatcher->setModuleName($router->getModuleName());
        $dispatcher->setNamespaceName($router->getNamespaceName());
        $dispatcher->setControllerName($router->getControllerName());
        $dispatcher->setActionName($router->getActionName());
        $dispatcher->setParams($router->getParams());
        $dispatcher->dispatch();
        print_r($router->getNamespaceName());
        $possibleResponse = $dispatcher->getReturnedValue();
        $response = $di->get('response');
        if (is_string($possibleResponse)) {
            $response->setContent($possibleResponse);
        }
        return $response;
    }

}