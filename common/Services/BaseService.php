<?php
/**
 *
 * 介于controller和model之间的服务层
 * 一般用于1、与数据库无关的逻辑处理 2、需要多个model联合处理的逻辑
 * 一个服务中应该不存在公共属性 各个方法相对独立除了可以相互调用应该没有公共属性
 * 服务推荐单例来使用
 * UserService::N()->getUser($id)  推荐这种用  这种方法实际返回的是一个单例
 * Date: 2017-06-21
 * Time: 17:25
 */

namespace Common\Services;

use Common\Core\BaseInjectable;
use Common\Exception\ModelNotFindException;
use Common\Models\WeCom;
use Common\Traits\ErrMsg;

class BaseService extends BaseInjectable
{
    protected $SESSION_BASE = 'ejshendeng_';
    protected $modelClass ='';
    /**
     * @param null $id
     * @return static
     * @throws ModelNotFindException
     */
    public function findModel($id = null)
    {
        $modelClass = $this->modelClass;
        if (!class_exists($modelClass)) {
            throw new ModelNotFindException('未找到模型' . $modelClass);
        }
        if ($id === null) {
            return new $modelClass();
        } else {
            $model = $modelClass::findFirst($id);
            if (empty($model)) {
                throw new ModelNotFindException('未找到模型数据');
            } else {
                return $model;
            }
        }
    }


}