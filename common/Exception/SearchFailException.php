<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-21
 * Time: 11:27
 */

namespace Common\Exception;
/**
 * 搜索信息没有找到时
 * Class SearchFailException
 * @package Common\Exception
 */
class SearchFailException extends LogicException
{
    protected $code=610;

}