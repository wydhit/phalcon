<?php

namespace Common\Services;

use Common\Exception\LogicException;
use Common\Exception\UserLoginFailException;
use Common\Models\WeUser;
use Common\Services\BaseService;

class UserService extends BaseService
{


    public function getTopUser()
    {
        return WeUser::find([
            'id>10'
        ]);
    }

    /**
     * @param $name
     * @param $password
     * @return WeUser|\Phalcon\Mvc\Model\ResultInterface
     * @throws UserLoginFailException
     */
    public function checkPassWord($name, $password)
    {
        if (is_array($password) || is_object($password)) {
            $password = serialize($password);
        }
        if (empty($name) || empty($password)) {
            throw new UserLoginFailException('用户或者密码不能为空');
        }
        $userInfo = WeUser::findFirst([
            'isdel=0 and u_name= :u_name: ',
            'bind' => ['u_name' => $name]
        ]);
        if (empty($userInfo)) {
            throw new UserLoginFailException('用户名不存在');
        }
        if (!$userInfo->checkPwd($password)) {
            throw new UserLoginFailException('密码不正确');
        }

        return $userInfo;
    }

    public function loginByName($u_name, $u_pass, $u_gic, $u_roleic)
    {
        $userInfo = $this->checkPassWord($u_name, $u_pass);
        if ($userInfo->ischeck != 1) {
            throw new UserLoginFailException('您还没通过审核,请稍后登录');
        }
        if ($userInfo->islock == 1) {
            throw new UserLoginFailException('您已经被管理员锁定');
        }
        $groupRepository = GroupService::instance();
        if (!$groupRepository->GicIsExist($userInfo->u_gic)) {
            throw new UserLoginFailException('用户组不存在');
        }
        if (!$groupRepository->roleicIsExist($userInfo->u_roleic,$userInfo->u_gic)) {
            throw new UserLoginFailException('用户角色不存在');
        }
        if (!is_array($u_gic)) $u_gic = [$u_gic];
        if (!in_array($userInfo->u_gic, $u_gic)) {
            throw new UserLoginFailException('你没有权限登陆[code:gic]');
        }
        if (!is_array($u_roleic)) {
            $u_roleic = [$u_roleic];
        }
        if (!in_array($userInfo->u_roleic, $u_roleic)) {
            throw new UserLoginFailException('你没有权限登陆[code:roleic]');
        }
        return $userInfo;
    }



    /**
     * 获取管理员登录信息
     * @return mixed
     */
    public function getBizerInfo()
    {
        return $this->session->get($this->SESSION_BASE . 'bizerInfo');
    }

    /**
     * 保存管理员登录信息
     * @param array $value
     */
    public function setBizerInfo($value = [])
    {
        $setValue['id'] = isset($value['id']) ? $value['id'] : 0;
        $setValue['u_nick'] = isset($value['u_nick']) ? $value['u_nick'] : ' ';
        $this->session->set($this->SESSION_BASE . 'bizerInfo', $setValue);
    }


}