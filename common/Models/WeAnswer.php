<?php

namespace Common\Models;

class WeAnswer  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $fid;/*问卷id*/
    public $answertime;/*答卷时间*/
    public $ip;/*答题者ip*/
    public $userid;/*答题者id*/
    public $answer_content;/*回答内容*/
    public $isdel;/*是否删除*/
    public $use_time;/*答卷所用时间*/
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_answer';
    }

    /**
     * @param mixed $parameters
     * @return WeAnswer[]|WeAnswer|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeAnswer|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}