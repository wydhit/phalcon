<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-22
 * Time: 16:42
 */

namespace Common\Traits;
use Common\Core\Csrf;

trait CsrfTrait
{
    public function checkCsrfToken($name = '')
    {
        return Csrf::instance()->checkCsrfToken($name);
    }

    public function setCsrfToken($name = '', $outTime = null)
    {
        Csrf::instance()->setCsrfToken($name, $outTime);
    }

}