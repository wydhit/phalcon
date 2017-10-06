<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-27
 * Time: 14:42
 */

namespace Common\Core;

use Common\Helpers\DiHelper;
use Phalcon\Di\Injectable;

/**
 * Class BaseInjectable
 * @package Common\Core
 *
 */
class BaseInjectable extends Injectable
{

    /**
     * @param $forceNew bool 是否强制返回一个新的实例
     * @return static
     */
    public static function instance($forceNew = true)
    {
        if ($forceNew) {
            return DiHelper::getDi()->get(get_called_class());
        } else {
            return DiHelper::getDi()->getShared(get_called_class());
        }
    }

}