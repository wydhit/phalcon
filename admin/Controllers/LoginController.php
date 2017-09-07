<?php

namespace Admin\Controllers;


use Common\Controllers\BaseController;
use Common\Services\AdminService;
use Common\Services\CommonService;
use Common\Services\GroupService;
use Phalcon\Http\Request;

class LoginController extends BaseController
{

    public function initialize()
    {
        $this->addData('assetUri', $this->config->get('application')->get('assetUri'));
        $this->addTitle('E家神灯系统管理登录');
    }

    public function indexAction()
    {
        $this->setCsrfToken('login');
        $validationJs = $this->getValidationRulesForJs();
        $this->addData('validationJs', $validationJs);
        return $this->actionRender();
    }

    public function outLoginAction()
    {
        AdminService::instance()->outAdminLogin();
        $this->response->redirect($this->url->get('/login'));
    }

    public function loginAction(Request $request)
    {
        $this->checkCsrfToken('login');
        $this->validationInput($request->get());
        $allowRuleIc = GroupService::instance()->getRoleicListByGroupIc('admin');
        $loginRes = AdminService::instance()->loginByName($request->get('u_name'), $request->get('u_pass'), 'admin', $allowRuleIc);

        AdminService::instance()->setAdminInfo([
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
}