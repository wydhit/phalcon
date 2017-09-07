<?php
namespace Common\Services;

use Common\Exception\LogicException;
use Common\Exception\UserLoginFailException;
use Common\Models\WeAdmin;
use Common\Models\WeUser;

/**
 * 管理员公共逻辑
 * Class AdminService
 * @package Common\Services
 */
class AdminService extends BaseService
{
    /**
     * @param $name
     * @param $password
     * @return WeUser|\Phalcon\Mvc\Model\ResultInterface
     * @throws UserLoginFailException
     */
    public function checkPassWord($name, $password)
    {
        $name=trim($name);
        if (is_array($password) || is_object($password)) {
            $password = serialize($password);
        }
        if (empty($name) || empty($password)) {
            throw new UserLoginFailException('用户或者密码不能为空');
        }
        $adminInfo = WeAdmin::findFirst([
            'u_name= :u_name: ',
            'bind' => ['u_name' => $name]
        ]);
        if (empty($adminInfo)) {
            throw new UserLoginFailException('用户名不存在'.$name);
        }

        if (!$adminInfo->checkPwd($password)) {
            throw new UserLoginFailException('密码不正确');
        }
        return $adminInfo;
    }

    public function loginByName($u_name, $u_pass, $u_gic, $u_roleic)
    {
        $adminInfo = $this->checkPassWord($u_name, $u_pass);
        if ($adminInfo->islock == 1) {
            throw new UserLoginFailException('您已经被管理员锁定');
        }
        $groupInfo=$adminInfo->belongGroup;
        if (empty($groupInfo)) {
            throw new UserLoginFailException('用户组不存在');
        }elseif ($groupInfo->isuse!=1){
            throw new UserLoginFailException('用户组已停用，禁止登陆');
        }
        $roleInfo=$adminInfo->belongRole;
        if (empty($roleInfo)) {
            throw new UserLoginFailException('用户角色不存在');
        }elseif ($roleInfo->isuse!=1){
            throw new UserLoginFailException('用户角色已停用，禁止登陆');
        }
        if (!is_array($u_gic)) $u_gic = [$u_gic];
        if (!in_array($adminInfo->u_gic, $u_gic)) {
            throw new UserLoginFailException('你没有权限登陆[code:gic]');
        }
        if (!is_array($u_roleic)) {
            $u_roleic = [$u_roleic];
        }
        if (!in_array($adminInfo->u_roleic, $u_roleic)) {
            throw new UserLoginFailException('你没有权限登陆[code:roleic]');
        }
        return $adminInfo;
    }

    /**
     * 获取管理员登录信息
     * @return mixed
     */
    public function getAdminInfo()
    {
        return $this->getInfo('admin');
    }

    /**
     * 保存管理员登录信息
     * @param array $value
     */
    public function setAdminInfo($value = [])
    {
        $this->setInfo('admin',$value);
    }

    public function outAdminLogin()
    {
        $this->outLogin('admin');
    }
    /**
     * 获取登陆信息
     * @param string $name
     * @return mixed
     */
    public function getInfo($name='')
    {
        return $this->session->get($this->SESSION_BASE . $name.'Info');
    }

    /**
     * 保存登陆信息
     * @param string $name
     * @param array $value
     */
    public function setInfo($name='',$value=[])
    {
        $this->session->set($this->SESSION_BASE .$name. 'Info', $value);
    }

    /**
     * 退出登录
     * @param $name
     */
    public function outLogin($name)
    {
        $this->session->set($this->SESSION_BASE .$name.'Info', '');
    }
    


}