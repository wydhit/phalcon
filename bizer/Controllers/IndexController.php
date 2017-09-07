<?php
namespace Bizer\Controllers;
use Bizer\Controllers\BizerController;

class IndexController extends BizerController
{
    public function indexAction()
    {
        return $this->render();
    }
}