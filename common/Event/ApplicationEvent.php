<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-27
 * Time: 9:22
 */

namespace Common\Event;


use Common\Exception\ServiceNoRunException;
use Common\Exception\ServiceRefuseException;
use Common\Helpers\ConfigHelper;
use Common\Helpers\DiHelper;
use Common\Helpers\StringHelper;
use Phalcon\Events\Event;

class ApplicationEvent
{
    public function beforeHandle($event,$app)
    {
        if (ConfigHelper::isDebug() && ConfigHelper::get('Debugbar', false)) {/*调试用的debug条*/
            DiHelper::getDi()->setShared('app', $app);
            (new \Snowair\Debugbar\ServiceProvider(COMMON_PATH . '/config/debugger_config.php'))->start();
        }
    }

    public function checkStart($event,$app)
    {
        $userIp = DiHelper::getRequest()->getClientAddress();
        $banIp =explode(',',ConfigHelper::get('banIp',''));
        /*检查ip是否被禁止*/
        if (in_array($userIp, $banIp)) {/*被禁ip*/
            throw new ServiceRefuseException('拒绝服务！');
        }
        /*检查系统是否关闭*/
        $whiteIp = explode(',',ConfigHelper::get('whiteIp'));
        if (!in_array($userIp, $whiteIp)) {/*白名单不检查*/
            if (ConfigHelper::get('isRun', 0) !== 1) {
                throw new ServiceNoRunException(ConfigHelper::get('noRunMessage', '服务维护中'));
            }
        }
    }

    public function afterSend($event,$app)
    {

        
    }
}