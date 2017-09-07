<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-28
 * Time: 15:08
 */

namespace Common\Exception;

/**
 *拒绝服务
 * 因为:
 * 1、ip被禁止
 * Class ServiceRefuseException
 * @package Common\Exception
 */
class ServiceRefuseException extends LogicException
{
    protected $code=630;

}