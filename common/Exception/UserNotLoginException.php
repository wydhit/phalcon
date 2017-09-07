<?php

namespace Common\Exception;

use Common\Helpers\HttpHelper;

/**
 * 用户未登录
 * Class UserNotLoginException
 * @package Common\Exception
 */
class UserNotLoginException extends LogicException
{
    protected $code = 650;

    public function __construct($message = '', array $data = [], array $errInput = [], $goUrl = null, $code = 999)
    {
        if (empty($message)) {
            $message = '您需要登录才能操作';
        }
        if ($goUrl === null) {
            $goUrl = '/login';
        }
        parent::__construct($message, $data, $errInput, $goUrl, $code);
    }

    public function returnHtml()
    {
        $goUrl = $this->getGoUrl();
        header("location:$goUrl");
    }
}