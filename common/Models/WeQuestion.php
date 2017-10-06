<?php

namespace Common\Models;

class WeQuestion  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $fid;/*问卷id*/
    public $type;/*类型*/
    public $title;/*名称*/
    public $des;/*描述*/
    public $content;/*具体问题*/
    public $cls;/*排序*/
    public $p;/*横向or竖向 备用*/
    public $isok;/*是否开启1开启  0关闭*/
    public $userid;/*操作用户id  前端不显示 查数据用*/
    public $creattime;
    public $updatetime;
    public $isdel;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_question';
    }

    /**
     * @param mixed $parameters
     * @return WeQuestion[]|WeQuestion|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeQuestion|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}