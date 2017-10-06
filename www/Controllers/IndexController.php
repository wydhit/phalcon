<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-22
 * Time: 15:29
 */

namespace Www\Controllers;


use Common\Helpers\TimeHelper;
use Phalcon\Mvc\Controller;

class IndexController extends Controller
{

    public function indexAction()
    {
        echo TimeHelper::Test();
        return "asdf";

    }

}