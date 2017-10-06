<?php

namespace Agent\Controllers;

use Common\Controllers\BaseController;
use Common\Exception\UserNotLoginException;
use Common\Helpers\StringHelper;
use Common\Services\AdminService;


class AgentController extends BaseController
{

    public $userInfo = [];/*当前登录的用户信息*//*包括id u_fullname u_gic u_roleic u_name */
    public $userId = 0;/*当前登录的用户id*/
    public $agentId=0;
    public $gic = '';/*当前登录的用户用户组ic*/
    public $roleic='';/*当前登录的用户角色ic*/

    public function initialize()
    {
        $this->userInfo = AdminService::instance()->getInfo('agent');
        $this->userId = isset($this->userInfo['id']) ? $this->userInfo['id'] : 0;
        $this->fullname = isset($this->userInfo['u_fullname']) ? $this->userInfo['u_fullname'] : "";
        $this->agentId = isset($this->userInfo['agentid']) ? $this->userInfo['agentid'] : "";
        $this->checkLogin();/*检查登录*/
        $this->checkAccess();/*检查权限*/
        $this->addData('userId', $this->userId);
        $this->addData('fullname', $this->fullname);
        $this->addData('gic', $this->gic);
        $this->addData('roleic', $this->roleic);
    }

    public function checkLogin()
    {
        if (empty($this->userInfo) || empty($this->userId)|| empty($this->agentId)) {
            throw new UserNotLoginException();
        }
    }

    public function checkAccess()
    {
        $this->gic = isset($this->userInfo['id']) ? $this->userInfo['id'] : '';
        $this->roleic = isset($this->userInfo['id']) ? $this->userInfo['id'] : '';
        
    }


}