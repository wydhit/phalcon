<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-14
 * Time: 11:36
 */

namespace Common\Helpers;

use Phalcon\Di;
use Phalcon\Di\FactoryDefault;
use Phalcon\DiInterface;

class DiHelper
{
    public static function getDi()
    {
        $di = Di::getDefault();
        if (is_null($di) || !$di instanceof DiInterface) {
            $di = new FactoryDefault();
        }
        return $di;
    }

    public static function getDirFromNameSpace($className = '', $allNameSpace = null)
    {
        if(empty($allNameSpace)){
            $allNameSpace=self::getDi()->get('loader')->getNamespaces();
        }
        $ds = DIRECTORY_SEPARATOR;
        $ns = "\\";
        foreach ($allNameSpace as $nsPrefix => $directories) {
            if (strpos($className, $nsPrefix) !== 0) {
                continue;
            }
            $fileName = substr($className, strlen($nsPrefix . $ns));
            $fileName = str_replace($ns, $ds, $fileName);
            if (empty($fileName)) {
                continue;
            }
            foreach ($directories as $directory) {
                $fixedDirectory = rtrim($directory, $ds) . $ds;
                $filePath = $fixedDirectory . $fileName . ".php";
                if ($filePath) {
                   return  dirname($filePath);
                }
            }
        }
        return false;
    }

}