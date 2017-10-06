<?php
namespace Bizer\Controllers;

use Common\Controllers\BaseController;
use Common\Exception\UserNotLoginException;
use Common\Services\AdminService;


class BizerController extends BaseController
{
    public $userInfo = [];/*当前登录的用户信息*//*包括id u_fullname u_gic u_roleic u_name */
    public $userId = 0;/*当前登录的用户id*/
    public $gic = '';/*当前登录的用户用户组ic*/
    public $roleic='';/*当前登录的用户角色ic*/
    public function initialize()
    {
        $this->userInfo = AdminService::instance()->getInfo('sysBizer');
        $this->userId = isset($this->userInfo['id']) ? $this->userInfo['id'] : 0;
        $this->fullname = isset($this->userInfo['u_fullname']) ? $this->userInfo['u_fullname'] : "";
        $this->checkLogin();/*检查登录*/
        $this->checkAccess();/*检查权限*/
        $this->addData('userId', $this->userId);
        $this->addData('fullname', $this->fullname);
        $this->addData('gic', $this->gic);
        $this->addData('roleic', $this->roleic);
    }
    public function checkLogin()
    {
        if (empty($this->userInfo) || empty($this->userId)) {
            throw new UserNotLoginException();
        }
    }

    public function checkAccess()
    {
        $this->gic = isset($this->userInfo['id']) ? $this->userInfo['id'] : '';
        $this->roleic = isset($this->userInfo['id']) ? $this->userInfo['id'] : '';

    }


}