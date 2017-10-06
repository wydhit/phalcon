<?php

namespace Common\Models;

class WeCommoneyaccount  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $comid;
    public $aall;
    public $acanuse;
    public $ain;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_commoneyaccount';
    }

    /**
     * @param mixed $parameters
     * @return WeCommoneyaccount[]|WeCommoneyaccount|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCommoneyaccount|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}