<?php

namespace Agent\Controllers;


use Common\Models\WeUser;

/**
 * Class GoodsController
 * @package Agent\Controllers
 */
class GoodsController extends AgentController
{

    public function listAction()
    {
        //WeUser::findFirst('id=1');
        return $this->render();
    }

}