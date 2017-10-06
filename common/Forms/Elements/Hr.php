<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-21
 * Time: 16:43
 */

namespace Common\Forms\Elements;


use Phalcon\Forms\Element;

class Hr extends Element
{
    public function __construct($name, $attributes = null)
    {
        $attributes['banAceRender']=isset($attributes['banAceRender'])?$attributes['banAceRender']:1;
        parent::__construct($name, $attributes);
    }

    public function render($attributes = null)
    {

        return '<hr>';
    }
}