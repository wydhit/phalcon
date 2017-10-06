<?php

namespace Common\Models;

class WeCount  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $myip;/*访问的ip号*/
    public $stimeint;/*时间*/
    public $type;/*访问内容类型0进入本模块*/
    public $num;/*session有效期连续访问次数*/
    public $stime;/*时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_count';
    }

    /**
     * @param mixed $parameters
     * @return WeCount[]|WeCount|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeCount|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}