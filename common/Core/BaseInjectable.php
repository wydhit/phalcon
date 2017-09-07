<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-27
 * Time: 14:42
 */

namespace Common\Core;

use Common\Helpers\DiHelper;
use \Phalcon\Mvc\Model\Query\BuilderInterface;
use Phalcon\Di\Injectable;
use Phalcon\Di;

/**
 * Class BaseInjectable
 * @package Common\Core
 *
 */
class BaseInjectable extends Injectable
{

    /**
     * @var $builder BuilderInterface
     */
    public $builder;

    public function initialize()
    {
        $this->builder = $this->modelsManager->createBuilder();
    }


    public function setDI(\Phalcon\DiInterface $dependencyInjector)
    {
        parent::setDI($dependencyInjector);
        $this->initialize();
    }

    /**
     * @param $forceNew bool 是否强制返回一个新的实例
     * @return static
     */
    public static function instance($forceNew = false)
    {
        if ($forceNew) {
            return DiHelper::getDi()->get(get_called_class());
        } else {
            return DiHelper::getDi()->getShared(get_called_class());
        }
    }

}