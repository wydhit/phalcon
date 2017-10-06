<?php

namespace Common\Models;

class WeDocument  extends BaseModel
{
    /*{{{fieldBegin Do not delete edit this line and Do not edit next area!!!*/
    public $id;
    public $uid;
    public $nick;
    public $cid;
    public $classid;
    public $specialid;
    public $author;
    public $comefrom;
    public $preimg;
    public $preimg2;
    public $preimg3;
    public $preimg4;
    public $preimg5;
    public $preimg6;
    public $preimg7;
    public $preimg8;
    public $preimg9;
    public $preimg10;
    public $hits;
    public $tags;
    public $descrip;
    public $cls;
    public $stime;
    public $euid;
    public $etime;
    public $enick;
    public $title;
    public $content;
    public $contentshow;
    public $readme;
    public $istop;
    public $isgood;
    public $ispass;
    public $isshow;
    public $isdel;
    public $isopen;
    public $other1;
    public $other2;
    public $other3;
    public $other4;
    public $other5;
    public $other6;
    public $other7;
    public $other8;
    public $other9;
    public $other10;
    public $imgurl;
    public $attr1;
    public $attr2;
    public $attr3;
    public $attr4;
    public $attr5;
    public $attr6;
    public $attr7;
    public $attr8;
    public $attr9;
    public $attr10;
    public $mykeywords;
    public $mydescription;
    /*fieldEnd Do not delete edit this line and Do not edit pre area!!!}}}*/

    public function getSource()
    {
        return 'we_document';
    }

    /**
     * @param mixed $parameters
     * @return WeDocument[]|WeDocument|\Phalcon\Mvc\Model\ResultSetInterface
     */
    public static function find($parameters = null)
    {
        return parent::find($parameters);
    }

    /**
     * @param mixed $parameters
     * @return WeDocument|\Phalcon\Mvc\Model\ResultInterface
     */
    public static function findFirst($parameters = null)
    {
        return parent::findFirst($parameters);
    }


}