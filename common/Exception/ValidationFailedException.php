<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-21
 * Time: 11:27
 */

namespace Common\Exception;
/**
 * 验证输入数据时验证失败
 * Class ValidationFailedException
 * @package Common\Exception
 *
 */
class ValidationFailedException extends LogicException
{
    public $code=660;

}