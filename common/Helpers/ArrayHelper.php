<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-18
 * Time: 13:57
 */

namespace Common\Helpers;


class ArrayHelper
{
    /**
     * 将二位数组的$column的键值作为外层数组的键名
     * 例如将id作为多条数据的键名
     * @param $array array
     * @param $index string|int
     * @return  array
     *
     */
    public static function changArrayByIndex($array, $index = '')
    {
        $res = [];
        if (empty($index)) {
            return $res;
        }
        foreach ($array as $item) {
            if (!isset($item[$index])) {
                return $res;
            }
            $res[$item[$index]] = $item;
        }
        return $res;
    }

    /**
     * 统计一个二维数组中某一个字段的总和
     * @param array $array
     * @param string $index
     * @return int;
     */
    public static function moreArraySum($array = [], $index = 'id')
    {
        $total = 0;
        foreach ($array as $v) {
            if (isset($v[$index])) {
                $total += $v[$index] * 1;
            }
        }
        return $total;
    }

}