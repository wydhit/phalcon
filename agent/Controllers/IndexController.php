<?php

namespace Agent\Controllers;

use Common\Forms\UserForm;
use Common\Helpers\StringHelper;
use Common\Models\WeUser;
use Common\Services\AdminService;
use Common\Validator\TempValidator;
use Phalcon\Di\Service;
use Phalcon\Http\Request;

class IndexController extends AgentController
{

    public function indexAction(WeUser $user,AdminService $admin)
    {
//        var_dump($_GET['userId']);
//        $f=new UserForm();
//        $a=new AdminService();

        //$comid=1;
       // $user->checkIsBelongCom($comid);

//        StringHelper::dd($user);
       // StringHelper::dd($admin->findModel($user->id));
       // $value = $this->get('comId');

        /*null,0,'',"\r\n","%@#$%___",' ' '0'*/
        //$data=[
        //   'login'=>'3.2'
        //];
        //LoginValidator::validWithException($data,['login']);
        //$a=WeOrder::findWithAlias([
        //     'id>1 ',
        //     'limit'=>200
        // ],'gods');
        // foreach ($a as $item) {
        //     $item->gods;
        //  }
        ///WeOrderGoods::addComgoods();

//
//        foreach ($a as $item) {
//            $item->gods;
//            //StringHelper::dd($item->gods,false);
//        }
        //return $this->render();
        // HttpHelper::returnJson($a);

        // $a=ComSearch::instance()->index($request);
        //$this->addData('a',$a);
        // echo "<PRE>";
        // var_dump($a);
        // TempValidator::validWithException(['title'=>'v','id'=>465]);

        return $this->render();
        //$this->addData('a',$a);
    }

    public function indexaAction()
    {
        $a = TempValidator::validWithException([]);

    }
}