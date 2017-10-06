<?php

namespace Agent\Controllers;


use Agent\Controllers\Validator\LoginValidator;
use Common\Controllers\BaseController;
use Common\Helpers\DiHelper;
use Common\Helpers\StringHelper;
use Common\Services\AdminService;
use Common\Services\CommonService;

class LoginController extends BaseController
{
    private $loginRole = ['agentadmin'];/*允许登陆的角色*/
    private $loginGroup = 'agent';

    public function initialize()
    {
        $this->addData('assetUri', $this->config->get('application')->get('assetUri'));
        $this->addTitle('E家神灯系统-代理商管理登录');
    }

    public function indexAction()
    {
        $this->setCsrfToken('login');
        return $this->actionRender();
    }

    public function outLoginAction(AdminService $admin)
    {
        $admin->outLogin('agent');
        $this->response->redirect($this->url->get('/login'));
    }

    public function loginAction(AdminService $admin, CommonService $common)
    {
        $this->checkCsrfToken('login');
        $loginRes = $admin->loginByName(
            $this->get('u_name'),
            $this->get('u_pass'),
            $this->loginGroup,
            $this->loginRole
        );
        $admin->setInfo('agent', [
            'id' => $loginRes->id,
            'u_name' => $loginRes->u_name,
            'u_fullname' => $loginRes->u_fullname,
            'u_gic' => $loginRes->u_roleic,
            'u_roleic' => $loginRes->u_gic,
            'agentid' => $loginRes->agentid,
        ]);
        if ($loginRes) {
            $goUrl = $common->getLoginFromUrl();
            return $this->sendSuccessJson('登陆成功', [], [], $goUrl);
        } else {
            return $this->sendErrorJson('登陆失败');
        }
    }
}