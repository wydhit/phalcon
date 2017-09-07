<?php
namespace Admin\Controllers;
use Admin\Controllers\AdminController;

class IndexController extends AdminController
{
    public function indexAction()
    {
        return $this->render();
    }
}