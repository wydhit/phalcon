<?php
namespace Tmp\Controllers;
use Tmp\Controllers\TmpController;

class IndexController extends TmpController
{
    public function indexAction()
    {
        return $this->render();
    }
}