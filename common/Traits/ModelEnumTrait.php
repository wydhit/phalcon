<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-31
 * Time: 9:50
 */

namespace Common\Traits;


trait ModelEnumTrait
{
    public function getTips($field = '', $value = null)
    {
        $trueField = $this->getTrueTipsField($field);
        if (empty($field) || !isset($this->$trueField)) {
            return '';
        }
        $all = self::$trueField;
        if ($value === null && isset($this->$field)) {
            $value = $this->$field;
        }
        if (isset($all[$value])) {
            return $all[$value];
        }
        return '';
    }

    public function getAllTips($field = '')
    {
        $trueField = $this->getTrueTipsField($field);
        if (!empty($field) && isset($this->$trueField)) {
            return $this->$trueField;
        } else {
            return [];
        }
    }

    protected function getTrueTipsField($field = '')
    {
        return '_' . $field . '_tips';
    }

}