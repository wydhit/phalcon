<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-15
 * Time: 17:33
 */

namespace Admin\Controllers;

use Common\Exception\LogicException;
use Common\Exception\ModelNotFindException;
use Common\Models\WeGroup;
use Common\Search\GroupSearch;
use Phalcon\Http\Request;

class GroupController extends AdminController
{

    public function listAction()
    {
        if ($this->request->isAjax()) {
            return GroupSearch::instance()->getGroupForGrid($this->request);
        } else {
            return $this->render();
        }
    }

    public function editAction(WeGroup $group = null)
    {
        if ($group === null) {
            throw new ModelNotFindException('参数错误');
        }
        if ($this->request->isAjax() && $this->request->isPost()) {
            return $this->_edit($group);
        } else {
            $this->addData('id', $group->id);
            $this->tag->setDefaults($group->toArray());
            $this->addData('validationJs', $this->getValidationRulesForJs());
            return $this->actionRender();
        }
    }

    private function _edit(WeGroup $group)
    {
        $this->validationInput();
        $group->title = $this->request->get('title', 'string');
        $group->ic = $this->request->get('ic', 'string');
        $group->cls = $this->request->get('cls', 'int');
        $group->isuse = $this->request->get('isuse', 'int');
        if ($group->save()) {
            return $this->sendSuccessJson('修改成功');
        } else {
            $message = $group->getMessages();
            $message = empty($message) ? '保存失败' : $message;
            return $this->sendErrorJson($message);
        }
    }

    public function addAction()
    {
        if ($this->request->isAjax() && $this->request->isPost()) {
            return $this->_add($this->request);
        } else {
            $this->addData('validationJs', $this->getValidationRulesForJs());
            return $this->actionRender();
        }
    }

    private function _add(Request $request)
    {
        $this->validationInput($request->get());
        $group = new WeGroup();
        $group->ic = $request->get('ic', 'string');
        $group->title = $request->get('title', 'string');
        $group->cls = $request->get('cls', 'string');
        $group->isuse=$request->get('isuse','int');
        $group->mytype = "group";
        if ($group->save()) {
            return $this->sendSuccessJson('添加成功');
        } else {
            $message = $group->getMessages();
            $message = empty($message) ? '添加失败' : $message;
            return $this->sendErrorJson($message);
        }
    }

    public function delAction(WeGroup $group = null)
    {
        if ($group === null) {
            return $this->sendErrorJson('没找到要删除的数据');
        }
        if ($group->delete()) {
            return $this->sendSuccessJson('删除成功');
        } else {
            return $this->sendErrorJson('删除失败');
        }

    }

    public function roleAction($gid=0)
    {
        if($this->request->isAjax()){
            return GroupSearch::instance()->RoleListForGrid($gid,$this->request);
        }else{
            $this->addData('gid',$gid);
            return $this->render();
        }
    }

    public function addRoleAction()
    {
         $groupId=$this->request->get('gid','int');
        if(empty($groupId)){
            throw new LogicException('操作错误');
        }
        if ($this->request->isAjax() && $this->request->isPost()) {
            return $this->_addRole($this->request);
        } else {
            $this->addData('gid',$groupId);
            $this->addData('validationJs', $this->getValidationRulesForJs());
            return $this->actionRender();
        }
    }

    private function _addRole(Request $request)
    {
        $this->validationInput($request->get());
        $gid=$request->get('gid','int');
        $groupInfo=WeGroup::findFirst('id='.$gid);
        if(empty($groupInfo)){
            return $this->sendErrorJson('用户组不存在');
        }
        if($groupInfo->isuse!=1){
            return $this->sendErrorJson('用户组不可用');
        }
        $role = new WeGroup();
        $role->pid=$gid;
        $role->ic = $request->get('ic', 'string');
        $role->title = $request->get('title', 'string');
        $role->cls = $request->get('cls', 'string');
        $role->isuse=$request->get('isuse','int');
        $role->mytype = "role";
        if ($role->save()) {
            return $this->sendSuccessJson('添加成功');
        } else {
            $message = $role->getMessages();
            $message = empty($message) ? '添加失败' : $message;
            return $this->sendErrorJson($message);
        }
    }
}