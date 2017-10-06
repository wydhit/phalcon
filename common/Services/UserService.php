<?php

namespace Common\Services;

use Common\Exception\LogicException;
use Common\Exception\UserLoginFailException;
use Common\Helpers\HttpHelper;
use Common\Models\WeGroup;
use Common\Models\WeUser;
use Common\Services\BaseService;
use Phalcon\Http\Request;

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
        if (!$groupRepository->roleicIsExist($userInfo->u_roleic, $userInfo->u_gic)) {
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
     * 注册会员
     */
    public function addMemberUser($u_mobile, $u_pass)
    {

    }

    /**
     * 增加后台管理员
     */
    public function addAdminUser()
    {

    }

    /**
     * 增加商家用户
     */
    public function addSysBizer($data, $agentid = 0)
    {

        $data['u_gic'] = 'agent';
        $data['u_roleic'] = 'sys';
        $user = new WeUser();
        $user->agentid = $agentid;
        return $user->addUser($data);
    }

    /**
     * 增加代理商用户
     */
    public function addAgentUser($data, $agentid = 0)
    {
        $data['u_gic'] = 'agent';
        $data['u_roleic'] = 'sys';
        $user = new WeUser();
        $user->agentid = $agentid;
        return $user->addUser($data);
    }

}