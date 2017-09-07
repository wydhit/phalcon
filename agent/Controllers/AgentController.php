<?php

namespace Agent\Controllers;

use Common\Controllers\BaseController;
use Common\Exception\UserNotLoginException;
use Common\Services\AdminService;


class AgentController extends BaseController
{

    public $agentInfo = [];
    public $agentId = 0;

    public function initialize()
    {
        $this->agentInfo = AdminService::instance()->getInfo('agent');
        $this->agentId = isset($this->agentInfo['id']) ? $this->agentInfo['id'] : 0;
        $this->addData('agentId', $this->agentId);
        $this->checkAdminLogin();
    }

    public function checkAdminLogin()
    {
        if (empty($this->agentInfo) || empty($this->agentId)) {
           // throw new UserNotLoginException();
        }
    }


}