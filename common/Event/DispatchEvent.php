<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 16:18
 */

namespace Common\Event;


use Common\Core\BaseInjectable;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\Model;

class DispatchEvent extends BaseInjectable
{


    public function beforeDispatchLoop(Event $event, Dispatcher $dispatcher)
    {
        $di = $this->getDI();
        $controllerName = $dispatcher->getControllerClass();
        $actionName = $dispatcher->getActiveMethod();
        if (!method_exists($controllerName, $actionName)) {
            return;
        }
        $ref = new \ReflectionMethod($controllerName, $actionName);
        $parameters = $ref->getParameters();
        $params = [];
        foreach ($parameters as $k => $parameter) {
            if (isset($parameter->getClass()->name)) {//类形式的 类型约束
                $className = $parameter->getClass()->name;
                /*如果传递过来的正好是约束的 不处理*/
                if ($dispatcher->getParam($k) instanceof $className) {
                    $params[] = $dispatcher->getParam($k);
                    continue;
                }
                /*如果继承Model 特殊处理下*/
                if (is_subclass_of($className, Model::class)) {
                    $id = $dispatcher->getParam($k, 'int', 0);
                    if ($id) {
                        $model = $className::findFirst($id);
                    } else {
                        $model = null;
                    }
                    if ($model instanceof Model) {
                        $params[] = $model;
                    } elseif ($parameter->allowsNull()) {
                        $params[] = null;
                    } else {
                        $params[] = $di->get($className);
                    }
                    continue;
                }
                $classNames = explode('\\', $className);
                $defaultService = strtolower(end($classNames));
                /*看看是不是默认的几个基本服务*/
                if ($di->has($defaultService)) {
                    $params[] = $di->getShared($defaultService);
                    continue;
                }
                $params[] = $di->getShared($className, [$dispatcher->getParam($k)]);
            } else {
                $defaultValue=$parameter->isDefaultValueAvailable()?$parameter->getDefaultValue():null;
                $params[] = $dispatcher->getParam($k,null,$defaultValue);
            }
        }
        $dispatcher->setParams($params);
    }
}