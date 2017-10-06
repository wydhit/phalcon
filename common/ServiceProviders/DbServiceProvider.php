<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-08-10
 * Time: 10:01
 */

namespace Common\ServiceProviders;


use Common\Helpers\Config;
use Common\Helpers\ConfigHelper;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\DiInterface;

/**
 * 数据库模型服务
 * Class DbServiceProvider
 * @package Common\ServiceProviders
 */
class DbServiceProvider extends ServiceProvider
{

    protected $depends = [
        EventManagerServiceProvider::class
    ];

    public function register(DiInterface $di)
    {
        $dbConfig=ConfigHelper::get('database',[],true);
        if (empty($dbConfig)) {
            return false;
        }
        /*数据库服务*/
        $di->setShared('db', function () use ($dbConfig) {
            $adapter = $dbConfig['adapter'];
            unset($dbConfig['adapter']);
            /**
             * @var $db \Common\Db\Mysql
             */
            $db = new $adapter($dbConfig);
            $db->setEventsManager($this->get('eventManager'));
            return $db;
        });

        $di->remove('modelsMetadata');
        $metaDataDir= ROOT_PATH . '/cache/metaData/';
        if(!file_exists($metaDataDir)){
            mkdir($metaDataDir);
        }
        $di->setShared('modelsMetadata', function () use ($metaDataDir) {
            return new \Phalcon\Mvc\Model\MetaData\Memory([
                "metaDataDir" =>$metaDataDir,
            ]);
        });
        return true;
    }
}