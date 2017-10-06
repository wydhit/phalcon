<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 15:49
 */

namespace Common\Event;


use Common\Exception\LogicException;
use Phalcon\DiInterface;

class DiEvent
{


    /**
     * @param $event
     * @param $di  DiInterface
     * @param $param
     * @return object|string
     */
    public function BeforeServiceResolve($event, $di, $param)
    {
        $parameters = $param['parameters'];
        if ($di->has($param['name'])) {
            return false;
        }
        if (!class_exists($param['name'])) {
            return false;
        }
        $reflectionClass = new \ReflectionClass($param['name']);
        if ($reflectionClass->getConstructor() === null) {/*没有构造函数*/
            return false;
        }

        $classParams = $reflectionClass->getConstructor()->getParameters();
        $newClassParams = [];
        foreach ($classParams as $k => $classParam) {
            $field = $classParam->name;
            if (isset($parameters[$field])) {
                $newClassParams[$field] = $parameters[$field];
            } elseif (isset($classParam->getClass()->name)) {
                if (!$classParam->getClass()->isInstantiable()) {
                    return false;
                }
                $deClass = $classParam->getClass()->name;
                $classNames = explode('\\', $deClass);
                $defaultService = strtolower(end($classNames));
                if ($di->has($defaultService)) {
                    $newClassParams[$field] = $di->get($defaultService);
                } else {
                    $newClassParams[$field] = $di->get($deClass);
                }
            } else {
                if ($classParam->isDefaultValueAvailable()) {
                    $newClassParams[$field] = $classParam->getDefaultValue();
                } else {
                    return false;
                }
            }
        }
        return $reflectionClass->newInstanceArgs($newClassParams);
    }

}