<?php

namespace Common\Models;

class WeAccount  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;
    public $unick;
    public $aall;/*账户总额*/
    public $acanuse;/*可用余额*/
    public $aout;/*支出*/
    public $ain;/*收入*/
    public $afrize;/*冻结*/
    public $mytype;/*类型*/
    public $mytypename;/*平台、酒店*/
    public $isfrize;
    public $comid;/*酒店id*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_account';
    }

    /**
     * @param mixed $parameters
     * @return WeAccount[]|WeAccount|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAccount|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}