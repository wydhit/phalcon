<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-13
 * Time: 14:42
 */

namespace Agent\Controllers;

use Agent\Forms\ComUserForm;
use Agent\Search\ComUserSearch;
use Common\Helpers\StringHelper;
use Common\Models\WeUser;
use Common\Services\UserService;

class BizerController extends AgentController
{
    /**
     * 商家用户列表
     * @param  $comUserSearch
     * @return bool|mixed|\Phalcon\Mvc\View
     */
    public function sysBizerListAction(ComUserSearch $comUserSearch)
    {
        if ($this->request->isPost()) {
            return $comUserSearch->getComUserByAgent($this->agentId);
        } else {
            return $this->render();
        }
    }

    /**
     * 商家用户编辑
     * @param WeUser $user
     * @return mixed
     */
    public function sysBizerEditAction(WeUser $user)
    {
        $form = ComUserForm::editForm($user);
        $user->checkIsBelongAgent($this->userId);/*检查是否属于本代理商*/
        if ($this->request->isPost()) {
            $form->isValidWithException($this->request->get());
            $user->assign($this->get(['u_nick', 'u_phone', 'u_mobile', 'u_mail']));
            $user->saveWithException();
            return $this->sendSuccessJson('执行成功');
        } else {
            $this->addData('form', $form);
            return $this->actionRender();
        }
    }

    public function sysBizerAddAction(UserService $user)
    {
        $form = ComUserForm::addForm(new WeUser());
        if ($this->request->isPost()) {
            $form->isValidWithException(
                $this->get(['u_name', 'u_pass', 'u_pass_c', 'u_nick', 'u_phone', 'u_mobile', 'u_mail'], 'string')
            );
            $user->addSysBizer(
                $this->get(['u_name', 'u_pass', 'u_pass', 'u_nick', 'u_phone', 'u_mobile', 'u_mail'], 'string'),
                $this->userId
            );
            return $this->sendSuccessJson('添加成功');
        } else {
            $this->addData('form', $form);
            return $this->actionRender();
        }
    }

    public function sysBizerPassEditAction(WeUser $user)
    {
        $user->checkIsBelongAgent($this->userId);
        $user->u_pass='';
        $form = ComUserForm::passWordForm($user);
        if ($this->request->isPost()) {
            $form->isValidWithException($this->get(['u_pass', 'u_pass_c']));
            $user->editPass($this->request->get('u_pass'));
            return $this->sendSuccessJson('修改成功');
        } else {
            $this->addData('form', $form);
            return $this->actionRender();
        }
    }

    public function sysBizerDelAction(WeUser $user)
    {
        $user->checkIsBelongAgent($this->userId);
        $user->sysBizerDel();
        return $this->sendSuccessJson('删除成功');
    }


}