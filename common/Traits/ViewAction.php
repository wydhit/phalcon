<?php
/**
 * 和模板相关的controller方法
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-07-11
 * Time: 10:37
 */

namespace Common\Traits;

use Phalcon\Mvc\View;


Trait  ViewAction
{
    use BaseTrait;

    /**
     * 向视图添加一条数据
     * @param string $name
     * @param string|mixed $value
     */
    public function addData($name = '', $value = '')
    {
        if ($name && is_string($name)) {
            $this->view->setVar($name, $value);
        }
    }

    /**
     * 向模板批量添加数据
     * @param array $data
     */
    public function addDataS($data = [])
    {
        if (!empty($data) && is_array($data)) {
            $this->view->setVars($data);
        }
    }

    /**
     * 只解析views/controller/action模板即Action View 不包括views下的index及layout
     * @param array $data
     * @param string $controllerName
     * @param string $actionName
     * @return bool|\Phalcon\Mvc\View
     */
    public function actionRender($data = [], $controllerName = '', $actionName = '')
    {
        $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
        return $this->render($data, $controllerName, $actionName);
    }

    /**
     * 解析模板
     * @param array $data
     * @param string $controllerName
     * @param string $actionName
     * @return bool|\Phalcon\Mvc\View
     */
    public function render($data = [], $controllerName = '', $actionName = '')
    {
        $this->addData('action', $this->dispatcher->getActionName());
        $this->addData('controller', $this->dispatcher->getControllerName());
        $this->addData('baseUrl', $this->config->application->baseUri);
        $this->addData('assetUri', $this->config->application->assetUri);
        $this->addDataS($data);
        $controllerName = empty($controllerName) ? $this->dispatcher->getControllerName() : $controllerName;
        $actionName = empty($actionName) ? $this->dispatcher->getActionName() : $actionName;
        $this->view->start()->render($controllerName, $actionName, $data);
        $this->view->finish();
        return $this->view->getContent();
    }

    private $breadCrumb = [];

    /**
     * 增加面包屑导航
     * @param string $text 显示文字
     * @param string $url 调转地址
     */
    protected function addBreadcrumb($text = '', $url = '')
    {
        $this->breadCrumb[] = ['text' => $text, 'url' => $url];
        $this->view->setVar('breadCrumb', $this->breadCrumb);
    }

    protected function addTitle($title, $clear = false)
    {
        if ($clear) {
            $this->tag->setTitle($title);
        } else {
            $this->tag->prependTitle($title);
        }
    }
    /**
     * 返回html格式的提示信息
     * @param string $status
     * @param string $msg
     * @param array $data
     * @param array $errInput
     * @param string $goUrl
     * @param bool $inDialog
     * @return bool|\Phalcon\Mvc\View
     */
    public function msg($status = 'error', $message = '', $data = [], $errInput = [], $goUrl = '', $inDialog = null)
    {
        if ($inDialog === null) {
            $inDialog = $this->request->get('inDialog');
        }
        if ($inDialog) {
            return $this->actionRender(compact('status', 'message', 'data', 'errInput', 'goUrl', 'inDialog'), 'msg', 'msg');
        }
        return $this->Render(compact('status', 'message', 'data', 'errInput', 'goUrl', 'inDialog'), 'msg', 'msg');
    }
    public function exportXls($data = [],$xlsName = '', $controllerName = '', $actionName = '')
    {
        if (empty($xlsName)) {
            $xlsName = date('Y-m-d') . uniqid();
        }
        header("Content-Type: application/vnd.ms-excel; charset=UTF-8");
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=$xlsName.xls ");
        header("Content-Transfer-Encoding: binary ");
        $actionName = empty($actionName) ? $this->dispatcher->getActionName() . "_export" : $actionName;
        return  $this->actionRender($data, $controllerName, $actionName);
    }

}