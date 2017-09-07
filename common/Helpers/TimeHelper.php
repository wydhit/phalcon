<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-02
 * Time: 16:43
 */

namespace Common\Helpers;


use Phalcon\Di;

class TimeHelper
{
    public static function changeIntToStr($time=0,$onlyYMD=false)
    {
        if($onlyYMD){
            return date('Y-m-d',$time);
        }else{
            return date('Y-m-d H:i:s',$time);
        }
    }
    
    public static function getStartTime($searchTime = '', $day = -7)
    {
        if (empty($searchTime)) {
            $returnTime = time() + $day * 3600 * 24;
        } else {
            $returnTime = strtotime($searchTime);
        }
        return strtotime(date('Y-m-d', $returnTime) . ' 00:00:00');
    }

    public static function getEndTime($searchTime = '', $day = 0)
    {
        if (empty($searchTime)) {
            $returnTime = time() + $day * 3600 * 24;
        } else {
            $returnTime = strtotime($searchTime);
        }
        return strtotime(date('Y-m-d', $returnTime) . ' 23:59:59');
    }

    public static function Test()
    {
        $url=DiHelper::getDi()->get('request')->getUri();
        if(!HttpHelper::isReturnJson() && strpos($url,'_debugbar')===false ){
            echo 't';
            echo microtime(true)-APP_BEGIN_TIME;
            echo 'm';
            echo memory_get_usage()-APP_BEGIN_MEMORY;
        }
    }


}