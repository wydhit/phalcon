<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:07
 */

namespace Common\ServiceProviders;

use Common\Helpers\Config;
use Common\Helpers\ConfigHelper;
use Phalcon\Logger\Multiple as LoggerMultiple;
use Phalcon\Logger\Adapter\File as FileLogger;
use Phalcon\Logger\Adapter\Firephp as FirephpLogger;
use \Phalcon\DiInterface;

/**
 * 日志系统
 * Class LoggerServiceProvider
 * @package common\ServiceProviders
 */
class LoggerServiceProvider extends ServiceProvider
{
    public function register(DiInterface $di)
    {

        $di->setShared('logger', function () {
            $logger = new LoggerMultiple();
            $loggerPath = ConfigHelper::get('application.logDir');
            $loggerPath = $loggerPath . DIRECTORY_SEPARATOR . date("Y");
            if (!is_dir($loggerPath)) {
                mkdir($loggerPath, 0777);
            }
            $loggerFile = $loggerPath . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';
            $textLogger = new FileLogger($loggerFile);
            $logger->push($textLogger);
            if (ConfigHelper::isDebug()) {
                $logger->push(new FirephpLogger());
            }
            return $logger;
        });

        $di->setShared('ExceptionLogger', function () {
            $logger = new LoggerMultiple();
            $loggerPath = ConfigHelper::get('application.logDir');
            $loggerPath = $loggerPath . DIRECTORY_SEPARATOR . date("Y");
            if (!is_dir($loggerPath)) {
                mkdir($loggerPath, 0777);
            }
            $loggerFile = $loggerPath . DIRECTORY_SEPARATOR . 'Exception' . date('Y-m-d') . '.log';
            $textLogger = new FileLogger($loggerFile);
            $logger->push($textLogger);
            if (ConfigHelper::isDebug()) {
                $logger->push(new FirephpLogger());
            }
            return $logger;
        });
    }

}