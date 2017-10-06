<?php

namespace Common\Models;

class WeMoneysetting  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $ic;
    public $title;
    public $readme;
    public $pid;
    public $cls;
    public $mytype;/*交易类型，虚拟或实际*/
    public $mytypename;
    public $opuser;/*对个人的财务操作*/
    public $opbiz;/*对平台的财务操作*/
    public $opplat;/*对平台的财务操作*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_moneysetting';
    }

    /**
     * @param mixed $parameters
     * @return WeMoneysetting[]|WeMoneysetting|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeMoneysetting|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}