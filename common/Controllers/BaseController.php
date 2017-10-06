<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-06-20
 * Time: 12:56
 */

namespace Common\Controllers;

use Common\Helpers\HttpHelper;
use Common\Traits\CsrfTrait;
use Common\Traits\SendJsonTrait;
use Common\Traits\ViewAction;
use Phalcon\Mvc\Controller;


class BaseController extends Controller
{
    use ViewAction;/*视图相关*/
    use CsrfTrait;
    use SendJsonTrait;/*返回json数据*/
    private function createForm()
    {
        /*  实验方法 自动创建一个表单*/
    }

    /**
     * 对request->get简单封装  支持用数组取回多个值
     * 默认都是用trim string过滤，如果以id结尾 增加 int 过滤
     * @param string $filed
     * @param string $otherFilter
     * @return array|mixed
     */
    public function get($filed = '', $otherFilter = '')
    {
        $filter = ['trim', 'string'];
        if (!empty($otherFilter)) {
            if (is_array($otherFilter)) {
                $filter = array_merge($filter, $otherFilter);
            } else {
                $filter[] = $otherFilter;
            }
        }
        if (is_array($filed)) {
            $res = [];
            foreach ($filed as $item) {
                if (strtolower(substr($item, -2, 2)) === 'id') {
                    $filter[] = 'int';
                }
                $res[$item] = $this->request->get($item, $filter);
            }
            return $res;
        } else {
            if (strtolower(substr($filed, -2, 2)) === 'id') {
                $filter[] = 'int';
            }
            return $this->request->get($filed, $filter);
        }
    }

    public function notFoundAction()
    {
        if (HttpHelper::isReturnJson()) {
            return $this->sendErrorJson('请求地址不存在');
        } else {
            return $this->msg('error','请求地址不存在');
        }
    }


}