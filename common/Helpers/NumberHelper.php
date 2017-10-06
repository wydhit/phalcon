<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-18
 * Time: 13:53
 */

namespace Common\Helpers;


class NumberHelper
{
    /**
     * 格式化金额 除100保留小数点两位
     * @param string $value
     * @return string
     */
    public static function renderMoney($value)
    {
        return number_format($value / 100, 2, '.', '');
    }

    public static function validMoney($money)
    {
        $reg = '/(^[-+]?[1-9]\d*(\.\d{1,2})?$)|(^[-+]?[0]{1}(\.\d{1,2})?$)/';
        return preg_match($reg, $money);
    }

    /**
     * 验证电话号码
     *
     * @param $mobile
     * @return int
     */
    public static function validMobile($mobile = '')
    {
        return preg_match('/^1(3|4|5|7|8)\d{9}$/', $mobile);
    }

}