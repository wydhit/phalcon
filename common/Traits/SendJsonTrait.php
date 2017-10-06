<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-22
 * Time: 16:44
 */

namespace Common\Traits;


use Common\Core\ReturnData;
use Common\Helpers\DiHelper;
use Phalcon\Http\Response;

trait SendJsonTrait
{
    /**
     * 返回错误json数据
     * @param string $msg
     * @param array $data
     * @param array $errInput
     * @return Response
     */
    public function sendErrorJson($msg = '', $data = [], $errInput = [], $goUrl = '', $code = 999)
    {
        return $this->sendJson('error', $msg, $data, $errInput, $goUrl, $code);
    }

    /**
     * 返回正确的json数据
     * @param string $msg
     * @param array $data
     * @param array $errInput
     * @return Response
     */
    public function sendSuccessJson($msg = '', $data = [], $errInput = [], $goUrl = '', $code = 0)
    {
        return $this->sendJson('success', $msg, $data, $errInput, $goUrl, $code);
    }

    /**
     * 返回json数据 通用方法
     * @param string $status 状态 约定只能是error 或者success
     * @param string|array $msg //返回的信息
     * @param array $data //返回的数据
     * @param array $errInput //字段错误信息
     * @param $goUrl string 跳转的url
     * @return Response
     */
    public function sendJson($status = 'error', $msg = '', $data = [], $errInput = [], $goUrl = '', $code = 0)
    {
        $data = new ReturnData($status, $msg, $data, $errInput, $goUrl, $code);
        $response=DiHelper::getDi()->get('response');
        $response->setHeader('Content-type', 'application/json');
        $response->setJsonContent($data->getReturnData());
        return $response;
    }

}