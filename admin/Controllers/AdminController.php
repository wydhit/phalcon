<?php
namespace Admin\Controllers;

use Common\Controllers\BaseController;
use Common\Exception\UserNotLoginException;
use Common\Services\AdminService;


class AdminController extends BaseController
{

    public $adminInfo=[];
    public $adminId=0;

    public function initialize()
    {
        $this->adminInfo=AdminService::instance()->getInfo('admin');
        $this->adminId=isset($this->adminInfo['id'])?$this->adminInfo['id']:0;
        $this->addData('adminInfo',$this->adminInfo);
        $this->checkAdminLogin();

    }

    public function checkAdminLogin()
    {
        if(empty($this->adminInfo) || empty($this->adminId)){
            //throw new UserNotLoginException();
        }
    }


}