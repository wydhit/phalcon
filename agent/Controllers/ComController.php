<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-08
 * Time: 16:09
 */

namespace Agent\Controllers;
use Agent\Forms\ComForm;
use Common\Models\WeCom;
use Agent\Forms\ComUserForm;
use Common\Models\WeUser;
use Common\Search\ComUserSearch;
use Common\Services\UserService;

class ComController extends AgentController
{


    public function listAction()
    {
        if($this->request->isPost()){
            return[];
        }else{
            return $this->render();
        }
    }

    public function comAddAction(WeCom $com)
    {
        $comUserId=$this->request->get('comUserID','int',0);
        $form=ComForm::addForm(null,['agentid'=>$this->userId,'comUserId'=>$comUserId]);
        if ($this->request->isPost()) {
            $form->isValidWithException($this->request->get());
            return $this->sendSuccessJson('添加成功');
        } else {
            $this->addData('form', $form);
            return $this->actionRender();
        }
    }


}