<?php
namespace Bizer\Controllers;


use Common\Controllers\BaseController;
use Phalcon\Http\Request;

class LoginController extends BaseController
{

    public function indexAction()
    {
        $this->setCsrfToken('login');
        return $this->actionRender();
    }

    public function outLoginAction()
    {
        $this->response->redirect($this->url->get('/login'));
    }

    public function loginAction(Request $request)
    {
        $this->checkCsrfToken('login');
        if(false){
            $goUrl='';
            return $this->sendSuccessJson('登陆成功',[],[],$goUrl);
        }else{
            return $this->sendErrorJson('登陆失败');
        }
    }
}