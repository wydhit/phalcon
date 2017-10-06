<?php

namespace Common\Core;

/**
 * 错误及异常处理器
 * 处理结果由Controller 输出 html 或者json
 * 需要记录的由logger记录
 */
use Common\Exception\ErrorException;
use Common\Exception\LogicException;
use Common\Helpers\ConfigHelper;
use Common\Helpers\DiHelper;
use Common\Helpers\HttpHelper;
use Phalcon\Http\Request;
use Phalcon\Logger;
use Phalcon\Version;

class ExceptionHandler
{
    private $debug;
    /**
     *
     * @var $request Request;
     */
    private $request;

    public function __construct($request = null)
    {
        if ($request !== null && is_object($request)) {
            $this->request = $request;
        } else {
            $this->request = DiHelper::getRequest();
        }
    }

    public function listen()
    {
        ini_set('display_errors', false);
        set_error_handler([$this, 'handleError']);
        set_exception_handler([$this, 'handleException']);
        register_shutdown_function([$this, 'handleFatalError']);
        return $this;
    }
    /*处理异常*/
    public function handleException($exception)
    {
        DiHelper::getResponse()->setStatusCode(200);
        $this->unregister();
        try {
            $this->logException($exception);//记录异常
            $this->renderException($exception);//报告异常
        } catch (\Exception $e) {//处理过程中有可能再次发生异常  尝试记录他
            $this->handleFallbackExceptionMessage($e, $exception);
        } catch (\Throwable $e) {
            $this->handleFallbackExceptionMessage($e, $exception);
        }
    }
    /*处理错误*/
    public function handleError($code, $message, $file = '', $line = 0)
    {
        if (error_reporting() & $code) {
            throw  new ErrorException($message, $code, $code, $file, $line);
        }
    }
    public function handleFatalError()
    {
        $error = error_get_last();
        if ($error && ErrorException::isFatalError($error)) {
            $exception = new ErrorException($error['message'], $error['type'], $error['type'], $error['file'], $error['line']);
            DiHelper::getResponse()->setStatusCode(200);
            $this->handleException($exception);
        }
    }

    /**
     * 处理输出异常信息
     * @param \Exception $exception
     */
    public function renderException($exception)
    {
        /*用户自定义特殊类型的异常 一般为业务逻辑异常  怎么处理有异常本身决定*/
        if ($exception instanceof LogicException && method_exists($exception, 'doException')) {
            return $exception->doException();
        }
        /*通用异常处理 */
        if ($this->isDebug()) {/*开发模式*/
            $message = $this->getMessage($exception);
        } else {/*正式线上*/
            $message = '服务异常 code:' . $exception->getCode();
        }
        if ($this->isReturnJson()) {
            HttpHelper::sendJson(['status' => 'error', 'message' => $message]);
        } else {
            HttpHelper::sendMessage(['status' => 'error', 'message' => $message]);
        }
        return true;
    }

    /**
     * 记录异常
     * @param \Exception $exception
     */
    public function logException($exception)
    {
        /**
         * 业务逻辑异常不记录
         */
        if ($exception instanceof LogicException) {
            return;
        }
        $message = $this->getMessage($exception);
        $di = DiHelper::getDi();
        if ($di->has('ExceptionLogger')) {
            /**
             * @var  $logger Logger\Adapter\File
             */
            $log = $di->get('ExceptionLogger');
            $type = self::getLogType($exception->getCode());
            $log->log($type, $message);
        } else {
            error_log($message . '[备注：没找到log服务,启动系统日志]');
        }
    }

    /**
     * 处理 处理异常时 发生的异常 应该很少情况下会发生
     * @param $exception
     * @param $previousException
     */
    protected function handleFallbackExceptionMessage($exception, $previousException)
    {
        $message = "处理异常是发生错误，错误信息\n";
        $message .= (string)$exception;
        $message .= "\n要处理的异常为:\n";
        $message .= (string)$previousException;
        error_log($message . "\n\$_SERVER = " . var_export($_SERVER, true));
        if (PHP_SAPI === 'cli') {
            echo $message . "\n";
        } else {
            if ($this->isDebug()) {
                $outMessage = '<pre>' . htmlspecialchars($message, ENT_QUOTES) . '</pre>';
            } else {
                $outMessage = '处理异常发生错误！';
            }
            if ($this->isReturnJson()) {
                HttpHelper::sendJson([
                    'status' => 'error',
                    'message' => $outMessage
                ]);
            } else {
                echo $outMessage;
            }
        }
    }

    /**
     * 是否调试模式下运行  在调试模式下 将暴露更多错误信息
     * @return bool
     */
    private function isDebug()
    {
        return ConfigHelper::isDebug();
    }
    /**
     * Exception转成字符串的错误信息
     * @param $exception \Exception
     * @return string
     */
    public function getMessage($exception)
    {
        $message = "message：" . $exception->getMessage() . "<hr>";
        $message .= "file：" . $exception->getFile() . "<hr>";
        $message .= "line：" . $exception->getLine() . "<hr>";
        //$message .= 'Trace:<br/>' . str_replace("#", "<br/>#\r\n", $exception->getTraceAsString());
        //$message .= "\n\$_SERVER = " . var_export($_SERVER, true);
        return $message;
    }

    /*注销错误异常处理器*/
    public function unregister()
    {
        restore_error_handler();
        restore_exception_handler();
    }

    /**
     * 是否应该返回json数据
     * @return bool
     */
    private function isReturnJson()
    {
        return HttpHelper::isReturnJson();
    }

    /**
     * Maps error code to a log type.
     *
     * @param  integer $code
     * @return integer
     */
    public static function getLogType($code)
    {
        switch ($code) {
            case E_ERROR:
            case E_RECOVERABLE_ERROR:
            case E_CORE_ERROR:
            case E_COMPILE_ERROR:
            case E_USER_ERROR:
            case E_PARSE:
                return Logger::ERROR;
            case E_WARNING:
            case E_USER_WARNING:
            case E_CORE_WARNING:
            case E_COMPILE_WARNING:
                return Logger::WARNING;
            case E_NOTICE:
            case E_USER_NOTICE:
                return Logger::NOTICE;
            case E_STRICT:
            case E_DEPRECATED:
            case E_USER_DEPRECATED:
                return Logger::INFO;
        }
        return Logger::ERROR;
    }

}