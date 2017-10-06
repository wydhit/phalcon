<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-13
 * Time: 16:42
 */

namespace Bizer\Controllers;


use Bizer\Search\ComSearch;
use Common\Forms\ComForm;
use Common\Forms\SearchForm;
use Common\Search\BaseSearch;
use Phalcon\Forms\Element\Text;

class ComController extends BizerController
{
    public function listAction()
    {
        if ($this->request->isPost()) {
            return ComSearch::instance()->comListBySysBizer($this->userId);
        } else {
            $searchForm=new SearchForm();
            $searchForm->setData(BaseSearch::instance()->getSearchAllData());
            $searchForm->add(new Text('title',['placeholder'=>'店铺名称']));
            $searchForm->addStartTime(date('Y-m-d',time()-7*24*3600));
            $searchForm->addEndTime();
            $this->addData('searchForm',$searchForm);
            return $this->render();
        }
    }

    public function addAction(ComForm $comForm)
    {
        $comForm=$this->get(ComForm::class);

    }

}