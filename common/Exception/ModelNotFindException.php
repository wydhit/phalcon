<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-21
 * Time: 11:27
 */

namespace Common\Exception;
/**
 * 从模型里查找数据查找不到时
 * 如 商品信息不存在
 */
class ModelNotFindException extends LogicException
{
    protected $code=600;
}