<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-18
 * Time: 13:39
 */

namespace Common\Helpers;


use Phalcon\Debug\Dump;

class StringHelper
{

    /**
     * 将,(或者$split)分割的多个id字符串转化为数组 同时转为整形 去除重复数据
     * @param string $idStr 包含id的字符串 1,12,31,23  或者 22|234|3423|
     * @param string $split 分割符号 , 或者| ....
     * @return array
     */
    public static function idsToArray($idStr = '', $split = ',')
    {
        $newArray = [];
        $ids = explode($split, $idStr);
        foreach ($ids as $id) {
            $id = (int)$id;
            if ($id > 0) {
                $newArray[] = $id;
            }
        }
        return array_unique($newArray);
    }

    /**
     * 将两个字符串之间的内容替换掉
     * @param string $start
     * @param string $end
     * @param string $str
     * @param $content
     * @return string
     */
    public static function changeStrBetween($content = '', $start = '', $end = '', $str = '')
    {
        if (empty($start) || empty($end)) {
            return $content;
        }
        if (strpos($content, $start) === false || strpos($content, $end) === false) {
            return $content;
        }
        $need = explode($start, $content)[1];
        $need = explode($end, $need)[0];
        return str_replace($need, $str, $content);
    }

    public static function dd($data, $isDie = true)
    {
        echo (new Dump())->variable($data);
        if ($isDie) {
            die();
        }

    }


}