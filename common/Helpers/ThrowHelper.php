<?php

namespace Common\Helpers;

use Common\Exception\LogicException;

/**
 * 异常辅助类
 * Class ThrowHelper
 * @package Common\Helpers
 */
class ThrowHelper
{
    /**
     * 根据条件抛出异常
     * @param $condition
     * @param string $message
     * @param null $exception
     * @throws LogicException
     */
    public static function ThrowIf($condition, $message = '', $exception = null)
    {
        if ($exception === null) {
            $exception = new LogicException($message);
        }
        if ($condition) {
            throw $exception;
        }
    }

    public static function ThrowIfEmpty($value, $message = '', $exception = null)
    {
        self::ThrowIf(empty($value), $message, $exception);
    }

    public static function ThrowIfNotEmpty($value, $message = '', $exception = null)
    {
        self::ThrowIf(!empty($value), $message, $exception);
    }

    public static function ThrowIfIsset($value, $message = '', $exception = null)
    {
        self::ThrowIf(isset($value), $message, $exception);
    }

    public static function ThrowIfNull($value, $message = '', $exception = null)
    {
        self::ThrowIf($value === null, $message, $exception);
    }

}
