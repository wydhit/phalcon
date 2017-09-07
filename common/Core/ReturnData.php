<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-09
 * Time: 16:47
 */

namespace Common\Core;

/*
 * json 统一返回数据格式
 * */

use Common\Helpers\DiHelper;
use Common\Helpers\HttpHelper;

class ReturnData
{

    private $code = 0;/*返回代码 0 表示执行成功 其他数字代表对应的错误*/
    private $message = '';/*返回的信息 一般为错误信息*/
    private $data = [];/*返回的数据 一般为正确执行返回的数据*/
    private $errInput = [];/*字段验证失败返回的信息 给输入表单用*/
    private $goUrl = '';/*可以给前端指定跳转的url*/
    private $status = 'error';/*状态*/
    public function __construct($status = 'error', $message = '', $data = [], $errInput = [], $goUrl = '', $code = 0)
    {
        $this->setCode($code);
        $this->setStatus($status);
        $this->setMessage($message);
        $this->setData($data);
        $this->setErrInput($errInput);
        $this->setGoUrl($goUrl);
    }

    public function assign($data = [])
    {
        isset($data['code']) && $this->setCode($data['code']);
        isset($data['status']) && $this->setStatus($data['status']);
        isset($data['message']) && $this->setMessage($data['message']);
        isset($data['data']) && $this->setData($data['data']);
        isset($data['errInput']) && $this->setErrInput($data['errInput']);
        isset($data['goUrl']) && $this->setGoUrl($data['goUrl']);
    }

    public function getReturnData()
    {
        return [
            'code' => $this->code,
            'status' => $this->status,
            'message' => $this->message,
            'data' => $this->data,
            'errInput' => $this->errInput,
            'goUrl' => $this->goUrl
        ];
    }

    public function getReturnJson()
    {
        return json_encode($this->getReturnData(),JSON_FORCE_OBJECT);
    }

    public function getReturnMessage($code = null)
    {
        $messageAll = [
            400 => '未找到',
            999 => '普通逻辑错误'

        ];
        if ($code === null) {
            return $messageAll;
        }
        if ($code === 0) {
            return '';
        }
        if (isset($messageAll[$code])) {
            return $messageAll[$code];
        } else {
            return '未知错误';
        }
    }


    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        if (is_array($message)) {
            $message = join("\r\n", $message);
        } elseif (!is_string($message)) {
            $message = (string)$message;
        }
        $this->message = trim($message);
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
        $this->data = is_array($data) ? $data : (array)$data;
    }

    /**
     * @return int
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @param int $code
     */
    public function setCode($code)
    {
        $this->code = (int)$code;
    }

    /**
     * @return int|string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param int|string $status
     */
    public function setStatus($status)
    {
        $this->status = in_array($status, ['success', 'error']) ? $status : 'error';
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
        $this->errInput = is_array($errInput) ? $errInput : (array)$errInput;
    }

    /**
     * @return string
     */
    public function getGoUrl()
    {
        return $this->goUrl;
    }

    /**
     * @param string $goUrl
     */
    public function setGoUrl($goUrl)
    {
        if(empty($goUrl)){
            $goUrl=DiHelper::getDi()->get('request')->getHTTPReferer();
        }
        $this->goUrl = $goUrl;
    }
}