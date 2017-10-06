<?php

namespace Common\Exception;

use Common\Helpers\DiHelper;
use Common\Helpers\HttpHelper;
use Phalcon\Exception;
use Phalcon\Http\Request;

class LogicException extends Exception
{
    public $status = 'error';
    public $data;
    public $errInput;
    public $goUrl;

    public function __construct($message = '', $data = [], $errInput = [], $goUrl = null, $code = 999)
    {
        if (is_array($message)) {
            $message = var_export($message, true);
        }
        $request = DiHelper::getRequest();
        $this->setStatus('error');
        $this->setData($data);
        $this->setErrInput($errInput);
        if ($goUrl === null) {
            $goUrl = $request->getHTTPReferer();
        }
        if (empty($goUrl)) {
            $goUrl = $request->getURI();
        }
        $this->setGoUrl($goUrl);
        if (!empty($this->code)) {
            $code = $this->code;
        }
        parent::__construct($message, $code);
    }

    /**
     * 处理异常的方法
     * 不同的异常可以重写returnJson和returnHtml方法进行特殊处理
     */
    public function doException()
    {
        if (HttpHelper::isReturnJson()) {
            $this->returnJson();
        } else {
            $this->returnHtml();
        }
    }

    public function returnHtml()
    {
        HttpHelper::sendMessage($this->outData());
    }

    public function returnJson()
    {
        HttpHelper::sendJson($this->outData());
    }

    public function outData()
    {
        return [
            'status' => $this->getStatus(),
            'message' => $this->getMessage(),
            'data' => $this->getData(),
            'errInput' => $this->getErrInput(),
            'goUrl' => $this->getGoUrl(),
            'code' => $this->getCode()
        ];
    }

    /**
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
    }

    /**
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     */
    public function setData($data)
    {
        $this->data = $data;
    }

    /**
     * @return array
     */
    public function getErrInput()
    {
        return $this->errInput;
    }

    /**
     * @param array $errInput
     */
    public function setErrInput($errInput)
    {
        $this->errInput = $errInput;
    }

    /**
     * @return null
     */
    public function getGoUrl()
    {
        return $this->goUrl;
    }

    /**
     * @param null $goUrl
     */
    public function setGoUrl($goUrl)
    {
        $this->goUrl = $goUrl;
    }

}