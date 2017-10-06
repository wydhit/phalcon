<?php

namespace Common\Models;

class className  /*$extends*/
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    /*$fields*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'tableName';
    }

    /**
     * @param mixed $parameters
     * @return className[]|className|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return className|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}