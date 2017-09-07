<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 11:07
 */

namespace Common\ServiceProviders;

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
        $config = $di->get('config');
        $di->setShared('logger', function () use ($config) {
            $logger = new LoggerMultiple();
            $loggerPath = $config->get('application')->logDir;
            $loggerPath = $loggerPath . DIRECTORY_SEPARATOR . date("Y");
            if (!is_dir($loggerPath)) {
                mkdir($loggerPath, 0777);
            }
            $loggerFile=$loggerPath . DIRECTORY_SEPARATOR . date('Y-m-d') . '.log';
            $textLogger = new FileLogger($loggerFile);
            $logger->push($textLogger);
            if (defined('APP_DEBUG') && APP_DEBUG) {
                $logger->push(new FirephpLogger());
            }
            return $logger;
        });

        $di->setShared('ExceptionLogger', function () use ($config) {
            $logger = new LoggerMultiple();
            $loggerPath = $config->get('application')->logDir;
            $loggerPath = $loggerPath . DIRECTORY_SEPARATOR . date("Y");
            if (!is_dir($loggerPath)) {
                mkdir($loggerPath, 0777);
            }
            $loggerFile=$loggerPath . DIRECTORY_SEPARATOR .'Exception'. date('Y-m-d') . '.log';
            $textLogger = new FileLogger($loggerFile);
            $logger->push($textLogger);
            if (defined('APP_DEBUG') && APP_DEBUG) {
                $logger->push(new FirephpLogger());
            }
            return $logger;
        });
    }

}