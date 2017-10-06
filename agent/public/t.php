<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-27
 * Time: 14:40
 */

$ch = curl_init();
$url="http://catapult.ejshendeng.com:50609/api/open/door/015620177839_11_DEVICETODEBUG_DTD01562017783915064943190525868";

$header = array(
    'CLIENT-IP:10.0.0.221',
    'X-FORWARDED-FOR:10.0.0.221'
);
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);

$page_content = curl_exec($ch);
curl_close($ch);
echo $page_content;
