<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-11
 * Time: 9:57
 */

namespace Common\Exception;


/**
 * 模型层执行异常 如不能更新保存删除等等
 * Class ModelExExecuteException
 * @package Common\Exception
 */
class ModelExExecuteException extends LogicException
{
    protected $code=670;

}