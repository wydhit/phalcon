<?php
namespace Bizer\Controllers;


use Common\Controllers\BaseController;
use Common\Services\AdminService;
use Common\Services\CommonService;
use Phalcon\Http\Request;

class LoginController extends BaseController
{
    private $loginRole = ['sys'];/*允许登陆的角色*/
    private $loginGroup = 'bizer';
    public function indexAction()
    {
        $this->setCsrfToken('login');
        return $this->actionRender();
    }

    public function outLoginAction()
    {
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
        $admin->setInfo('sysBizer', [
            'id' => $loginRes->id,
            'u_name' => $loginRes->u_name,
            'u_fullname' => $loginRes->u_nick,
            'u_gic' => $loginRes->u_roleic,
            'u_roleic' => $loginRes->u_gic,
        ]);
        if ($loginRes) {
            $goUrl = $common->getLoginFromUrl();
            return $this->sendSuccessJson('登陆成功', [], [], $goUrl);
        } else {
            return $this->sendErrorJson('登陆失败');
        }
    }
}