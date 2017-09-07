<?php

namespace Agent\Controllers;


use Common\Controllers\BaseController;
use Common\Helpers\DiHelper;
use Common\Services\AdminService;
use Common\Services\CommonService;
use Common\Services\GroupService;
use Phalcon\Http\Request;
use Phalcon\Loader;

class LoginController extends BaseController
{
    private $loginRole = ['agentOwner'];/*允许登陆的角色*/
    private $loginGroup='agent';

    public function initialize()
    {
        $this->addData('assetUri', $this->config->get('application')->get('assetUri'));
        $this->addTitle('E家神灯系统-代理商管理登录');
    }

    public function indexAction()
    {
        $this->createValidator();
        $this->setCsrfToken('login');
        $validationJs = $this->getValidationRulesForJs();
        // $this->addData('validationJs', $validationJs);
        return $this->actionRender();
    }

    public function outLoginAction()
    {
        AdminService::instance()->outLogin('agent');
        $this->response->redirect($this->url->get('/login'));
    }

    public function loginAction(Request $request)
    {
        $this->checkCsrfToken('login');
        $this->validationInput($request->get());
        $u_name = $request->get('u_name');
        $u_pass = $request->get('u_pass');
        $loginRes = AdminService::instance()->loginByName($u_name, $u_pass,$this->loginGroup, $this->loginRole);
        AdminService::instance()->setInfo('agent', [
            'id' => $loginRes->id,
            'u_name' => $loginRes->u_name,
            'u_nick' => $loginRes->u_nick
        ]);
        if ($loginRes) {
            $goUrl = CommonService::instance()->getLoginFromUrl();
            return $this->sendSuccessJson('登陆成功', [], [], $goUrl);
        } else {
            return $this->sendErrorJson('登陆失败');
        }
    }

    public function createValidator()
    {
        $className = $this->dispatcher->getControllerClass();
        $controllerName = $this->dispatcher->getControllerName();
        $actionName = $this->dispatcher->getActionName();
        $allNameSpace = $this->loader->getNamespaces();
        $dir = DiHelper::getDirFromNameSpace($className,$allNameSpace);
        $validatorClassName=ucfirst($controllerName) . ucfirst($actionName).'Validator';
        $validatorFile = $dir . '/Validator/' . $validatorClassName. '.php';

    }
}