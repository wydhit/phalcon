<?php
namespace Com\Controllers;
use Com\Controllers\ComController;

class IndexController extends ComController
{
    public function indexAction()
    {
        return $this->render();
    }
}