<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-20
 * Time: 12:56
 */

namespace Common\Controllers;

use Common\Core\Csrf;
use Common\Core\ReturnData;
use Common\Helpers\HttpHelper;
use Common\Traits\ControllerValid;
use Common\Traits\ViewAction;
use Phalcon\Http\Response;
use Phalcon\Mvc\Controller;


class BaseController extends Controller
{
    use ViewAction;
    use ControllerValid;

    public function createValidator()
    {
     //   echo get_called_class();
        //var_dump(get_included_files());

    }


    public function checkCsrfToken($name = '')
    {
        return Csrf::instance()->checkCsrfToken($name);
    }

    public function setCsrfToken($name = '', $outTime = null)
    {
        Csrf::instance()->setCsrfToken($name, $outTime);
    }

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
        HttpHelper::returnJson($data);
        $this->response->setHeader('Content-type', 'application/json');
        return $this->response->setJsonContent($data->getReturnData());
    }

    /**
     * 返回html格式的提示信息
     * @param string $status
     * @param string $msg
     * @param array $data
     * @param array $errInput
     * @param string $goUrl
     * @param bool $inDialog
     * @return bool|\Phalcon\Mvc\View
     */
    public function msg($status = 'error', $message = '', $data = [], $errInput = [], $goUrl = '', $inDialog = null)
    {
        if ($inDialog === null) {
            $inDialog = $this->request->get('inDialog');
        }
        if ($inDialog) {
            return $this->actionRender(compact('status', 'message', 'data', 'errInput', 'goUrl', 'inDialog'), 'msg', 'msg');
        }
        return $this->Render(compact('status', 'message', 'data', 'errInput', 'goUrl', 'inDialog'), 'msg', 'msg');
    }

    public function notFoundAction()
    {
        if (HttpHelper::isReturnJson()) {
            return $this->sendErrorJson('请求地址不存在');
        } else {
            return HttpHelper::returnMessage(['message'=>'请求地址不存在']);
        }
    }
}