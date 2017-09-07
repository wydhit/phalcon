<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-28
 * Time: 15:01
 */

namespace Common\Exception;
/**
 * 服务未运行
 * Class ServiceNoRunException
 * @package Common\Exception
 */
class ServiceNoRunException extends LogicException
{
    protected $code=620;

}