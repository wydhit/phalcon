<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-25
 * Time: 9:44
 */

namespace Common\Helpers;

use Common\Core\ReturnData;
use Phalcon\Di;
use Phalcon\Exception;
use Phalcon\Http\Request;
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
        if (DiHelper::getRequest()->get('inDialog')) {
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
        return DiHelper::getRequest()->getBestAccept() === 'application/json';
    }

    /**
     * 控制器之外输出json
     * @param $data
     */
    public static function sendJson($data)
    {
        self::registerEvent();
        $returnData = new ReturnData();
        $returnData->assign($data);
        DiHelper::getResponse()->setJsonContent($returnData->getReturnData())->send();
    }

    public static function sendMessage($data, $viewPath = 'msg', $viewFile = 'msg')
    {
        self::registerEvent();
        $di = DiHelper::getDi();
        if (!$di->has('view')) {/*还没注册视图系统*/
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
        $view->setViewsDir(self::getViewsDir($viewPath, $viewFile));
        $view->registerEngines(['.phtml' => 'Phalcon\Mvc\View\Engine\Php']);
        $view->setVar('title', $title);
        $view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        $view->setVars($data);
        $html = $view->start()->render($viewPath, $viewFile)->finish()->getContent();
        /**
         * @var $response Response
         */
        $response = $di->get('response');
        if (!$response->isSent()) {
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
        if (ConfigHelper::isDebug() && ConfigHelper::get('Debugbar', false)) {
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

    public static function getViewsDir($viewPath = 'msg', $viewFile = 'msg')
    {
        $appViewsDir = ConfigHelper::get('application.viewsDir');
        if (!empty($appViewsDir) && file_exists($appViewsDir . '/' . $viewPath . '/' . $viewFile . 'phtml')) {
            return $appViewsDir;
        } else {
            return COMMON_PATH . '/views';
        }
    }

    public static function getIp()
    {
        if (isset($_SERVER)) {
            if (isset($_SERVER["HTTP_X_FORWARDED_FOR"])) {
                $IP = $_SERVER["HTTP_X_FORWARDED_FOR"];
            } else if (isset($_SERVER["HTTP_CLIENT_IP"])) {
                $IP = $_SERVER["HTTP_CLIENT_IP"];
            } else {
                $IP = $_SERVER["REMOTE_ADDR"];
            }
        } else {
            if (getenv("HTTP_X_FORWARDED_FOR")) {
                $IP = getenv("HTTP_X_FORWARDED_FOR");
            } else if (getenv("HTTP_CLIENT_IP")) {
                $IP = getenv("HTTP_CLIENT_IP");
            } else {
                $IP = getenv("REMOTE_ADDR");
            }
        }
        return $IP;
    }

    public static function currentUrl()
    {
        $request = DiHelper::getRequest();
        return 'http://' . $request->getHttpHost() . $request->getURI();
    }

    public static function preImgHtml($preimg = '', $width = '', $height = '', $alt = '', $style = '')
    {
        $preimgUri = ConfigHelper::get('preimgUri');
        $preimg = trim($preimgUri, '/') . '/' . trim($preimg, '/');
        return Tag::image([
            $preimg,
            'alt' => $alt,
            'width' => $width,
            'height' => $height,
            'style' => $style,
        ]);
    }

    public static function page($recordTotal = 0, $pageNum = 20, $pageKey = 'page')
    {
        $page = DiHelper::getRequest()->get($pageKey, 'int', 1);
        $pageTotal = ceil($recordTotal / $pageNum);
        $firstUrl = self::pageUrl(1, $pageKey);
        $str = " <li class=\"paginate_button previous\"><a href=\"$firstUrl\">首页</a></li>";
        if ($page > 1) {
            $url = self::pageUrl($page - 1, $pageKey);
            $str .= "<li class=\"paginate_button previous\"><a href=\"$url\">上一页</a></li>";
        }

        for ($i = ($page - 5); $i < $page; $i++) {
            if ($i >= 1) {
                $url = self::pageUrl($i, $pageKey);
                $str .= "<li  class='paginate_button'><a href='$url'>$i</a></li>";
            }
        }
        for ($i = $page; $i < ($page + 5); $i++) {
            if ($i <= $pageTotal && $i >= 1) {
                if ($i == $page) {
                    $active_class = 'active';
                } else {
                    $active_class = '';
                }
                $url = self::pageUrl($i, $pageKey);
                $str .= "<li  class='paginate_button $active_class'><a href='$url'>$i</a></li>";
            }
        }
        if (($page + 1) <= $pageTotal) {
            $url = self::pageUrl($page + 1, $pageKey);
            $str .= " <li class=\"paginate_button next\"><a href=\"$url\">下一页</a></li>";
        }
        $url = self::pageUrl($pageTotal, $pageKey);
        $str .= "<li class=\"paginate_button previous\"><a href=\"$url\">尾页</a></li>";
        return $str;
    }

    public static function pageUrl($page, $pageKey = 'page')
    {
        $baseUrl = explode('?', self::currentUrl())[0];
        $query = DiHelper::getRequest()->getQuery();
        unset($query['_url']);
        $query[$pageKey] = $page;
        return $baseUrl . "?" . http_build_query($query);


    }

}