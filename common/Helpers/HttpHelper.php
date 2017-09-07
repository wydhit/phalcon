<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-25
 * Time: 9:44
 */

namespace Common\Helpers;

use Common\Core\ReturnData;
use Phalcon\Exception;
use Phalcon\Http\Response;
use Phalcon\Mvc\Url;
use Phalcon\Mvc\View;
use Phalcon\Tag;


class HttpHelper
{
    /**
     * 是否在dialog内发起的请求
     * @return bool
     */
    public static function isInDialog()
    {
        if (DiHelper::getDi()->get('request')->get('inDialog')) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * 是不是应该返回json
     * @return bool
     */
    public static function isReturnJson()
    {
        $request = DiHelper::getDi()->get('request');
        return $request->getBestAccept() === 'application/json';
    }

    /**
     * 控制器之外输出json
     * @param $data
     */
    public static function returnJson($data)
    {
        self::registerEvent();
        $returnData = new ReturnData();
        $returnData->assign($data);
        $di = DiHelper::getDi();
        $di->get('response')
            ->setHeader('Content-type', 'application/json')
            ->setJsonContent($returnData->getReturnData())
            ->send();
    }

    public static function returnMessage($data, $viewPath = 'msg', $viewFile = 'msg')
    {
        self::registerEvent();
        $di = DiHelper::getDi();
        if (!$di->has('view')) {/*已经注册视图系统*/
            $di->setShared('view', function () {
                return new View();
            });
        }
        if (isset($data['status'])) {
            $title = ($data['status'] === 'success') ? '成功！' : '错误信息';
        } else {
            $title = '提示信息';
        }
        /**
         * @var $view View
         */
        $view = $di->get('view');
        $view->reset()->finish();/*清理掉之前的所有输出*/
        $view->setViewsDir(self::getViewsDir());
        $view->registerEngines(['.phtml' => 'Phalcon\Mvc\View\Engine\Php']);
        $view->setVar('title', $title);
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->setVars($data);
        $html = $view->start()->render($viewPath, $viewFile)->finish()->getContent();
        /**
         * @var $response Response
         */
        $response=$di->get('response');
        if(!$response->isSent()){
            $response->setContent($html)->send();
        }

    }

    /**
     * 控制器之外通过视图输出数据 暂停使用
     * @param $data
     * @param string $viewPath
     * @param string $viewFile
     * @deprecated
     */
    public static function returnHtml($data, $viewPath = 'msg', $viewFile = 'msg')
    {
        self::registerEvent();
        $di = DiHelper::getDi();
        if (!$di->has('view')) {/*已经注册视图系统*/
            $di->setShared('view', function () {
                $view = new View();
                $view->setViewsDir(PROJECT_PATH . '/views');
                $view->registerEngines(['.phtml' => 'Phalcon\Mvc\View\Engine\Php']);
                return $view;
            });
        }
        /**
         * @var $view View
         */

        $view = $di->get('view');

        //if (self::isInDialog()) {
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        //}
        $view->setVars($data);
        $html = $view->start()->render($viewPath, $viewFile)->finish()->getContent();
        $di->get('response')->setContent($html)->send();
    }

    public static function registerEvent()
    {
        $di = DiHelper::getDi();
        if (defined('APP_DEBUG') && APP_DEBUG && $di->has('config') && $di->get('config')->get('Debugbar', false)) {
            echo "Asfasdfas";
            $di->get('eventManager')->fire("application:beforeSendResponse", $di['app'], $di['response']);
        }
    }

    /**
     * 生成url  $url+/$param/+?$get
     * @param $url
     * @param array|string $params
     * @param array $get
     * @return string
     * @throws Exception
     */
    public static function url($url, $params = [], $get = [])
    {
        $di = DiHelper::getDi();
        /**
         * @var $urlManager Url
         */
        $urlManager = $di->get('url');
        if (is_array($params)) {
            $paramStr = join('/', $params);
        } elseif (is_string($params)) {
            $paramStr = trim($params, '/');
        } else {
            throw new Exception('params must be array or string');
        }
        $url = trim($url, '/');
        if (!empty($paramStr)) {
            $url = '/' . $paramStr;
        }
        return $returnUrl = $urlManager->get($url, $get);

    }

    public static function getViewsDir()
    {
        $di = DiHelper::getDi();
        if($di->has('config')){
            return $di->get('config')->path('application.viewsDir');
        }else{
            return COMMON_PATH.'/views';
        }
        
    }
    
}