<?php

namespace Agent\Controllers;

use Common\Db\Query;
use Common\Helpers\HttpHelper;
use Common\Helpers\StringHelper;
use Common\Helpers\TimeHelper;
use Common\Models\BaseModel;
use Common\Models\WeAccount;
use Common\Models\WeOrder;
use Common\Models\WeOrderGoods;
use Common\Models\WeUser;
use Common\Search\ComSearch;
use Common\Validator\TempValidator;
use Phalcon\Debug\Dump;
use Phalcon\Http\Request;

class IndexController extends AgentController
{
    public function indexAction(Request $request)
    {
        $a=WeOrder::findWithAlias([
            'id>1 ',
            'limit'=>200
        ],'gods');
        foreach ($a as $item) {
            $item->gods;
         }
         WeOrderGoods::addComgoods();

//
//        foreach ($a as $item) {
//            $item->gods;
//            //StringHelper::dd($item->gods,false);
//        }
        //return $this->render();
        HttpHelper::returnJson($a);

       // $a=ComSearch::instance()->index($request);
        //$this->addData('a',$a);
      // echo "<PRE>";
      // var_dump($a);
       // TempValidator::validWithException(['title'=>'v','id'=>465]);

        //return $this->render();
        //$this->addData('a',$a);
    }

    public function indexaAction()
    {
        $a= TempValidator::validWithException([]);

    }
}