<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-22
 * Time: 14:48
 */

namespace Common\Helpers;

class ConfigHelper
{
    public static function get($path, $defaultValue = '',$needArray=false)
    {
        $di = DiHelper::getDi();
        if ($di->has('config')) {
            $value= $di->get('config')->path($path, $defaultValue);
        } else {
            $value= $defaultValue;
        }
        return $needArray?(array)$value:$value;
    }

    public static function isDebug()
    {
        return self::get('debug',false);
    }
}