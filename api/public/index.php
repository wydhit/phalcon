<?php

namespace My;
///*这三个必须定义*/
//define('ROOT_PATH', dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR);//总的根目录
//define('PROJECT_PATH', ROOT_PATH . 'api' . DIRECTORY_SEPARATOR);//当前项目目录
//define('COMMON_PATH', ROOT_PATH . 'common' . DIRECTORY_SEPARATOR);//通用目录
//
/////*注册自动加载器*/
//$loader = require COMMON_PATH . '/config/loader.php';
//$loader->registerNamespace([
//    'Api'=>PROJECT_PATH
//],true);
///*注册错误处理*/
///*启动系统*/
//$bootstrap = new \Api\Bootstrap($loader);
//$bootstrap->run();

use Common\Exception\LogicException;
use Phalcon\Exception;
use Phalcon\Http\Request;

$t = microtime(true);

class test implements \Phalcon\Di\InjectionAwareInterface
{
    public $di;
    private $request;

    public function __construct(Request $request = null, $a = 'aaa',$eaaaa='a')
    {
        $this->request = $request;
        echo $a;
    }

    public function getDI()
    {
        return $this->di;
    }

    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        $this->di = $dependencyInjector;
    }


    /**
     * @return \Phalcon\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}

$event = new \Phalcon\Events\Manager();
$event->attach('di:beforeServiceResolve', function ($event, $di, $param) {
    $parameters = $param['parameters'];
    $reflectionClass = new \ReflectionClass($param['name']);
    if ($reflectionClass->getConstructor() === null) {/*没有构造函数*/
        return '';
    }
    $classParams = $reflectionClass->getConstructor()->getParameters();
    $newClassParams = [];
    foreach ($classParams as $k=>$classParam) {
        $field=$classParam->name;
        if (isset($parameters[$field])) {
            $newClassParams[$field] = $parameters[$field];
        } elseif (isset($classParam->getClass()->name)) {
            $deClass = $classParam->getClass()->name;

            $classNames = explode('\\', $deClass);
            $defaultService = strtolower(end($classNames));
            if ($di->has($defaultService)) {
                $newClassParams[$field] = $di->getShared($defaultService);
            } else {
                $newClassParams[$field] = $di->getShared($deClass);
            }

        } else {
            if ($classParam->isDefaultValueAvailable()) {
                $newClassParams[$field] = $classParam->getDefaultValue();
            } else {
                throw new Exception($param['name'].':construct:'.$field.'  must have default value');
            }
        }
    }
    return $reflectionClass->newInstanceArgs($newClassParams);
});

$di = new \Phalcon\Di();
//$di->set('request','\Phalcon\Http\Request');
//$di->get('request');
$di->setInternalEventsManager($event);
$m = $di->get('My\test', ['a' => '是其他的']);
print_r($m);
echo microtime(true) - $t;