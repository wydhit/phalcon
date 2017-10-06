<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-25
 * Time: 11:36
 */

namespace Common\Forms\Elements;


use Common\Tags\CommonTags;
use Phalcon\Forms\Element;

class DatePicker extends Element
{
    public function render($attributes = null)
    {
       return CommonTags::datePicker($this->getName(),$this->getValue());
    }

}