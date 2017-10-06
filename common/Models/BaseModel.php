<?php

namespace Common\Models;

use Common\Exception\LogicException;
use Common\Exception\ModelExExecuteException;
use Common\Exception\ValidationFailedException;
use Common\Helpers\DiHelper;
use Common\Helpers\NumberHelper;
use Common\Helpers\TimeHelper;
use \Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Resultset\Simple;
use Phalcon\Tag;
use Phalcon\Validation\Validator\PresenceOf;

/**
 * Class BaseModel
 * @package Common\Models
 */
class BaseModel extends Model
{
    private static $modelRelationCache = [];
    /**
     * 利用模型关系设置 一次性把所有关联数据都读取出来
     * @param string $alias
     * @param null $parameters
     * @return Model\ResultsetInterface
     */
    public static function findWithAlias($parameters = null, $alias = '', $param = [])
    {

        $models = self::find($parameters);
        if (empty($alias)) {
            return $models;
        }
        $modelName = get_called_class();/*Common\Models\WeOrder*/
        $di = DiHelper::getDi();
        /**
         * @var $manager Model\Manager;
         */
        $manager = $di->getShared("modelsManager");
        $alias = strtolower($alias);/*关联模型别名*/
        $relation = $manager->getRelationByAlias($modelName, $alias);/*获取关联关系*/
        if (!$relation instanceof Model\Relation) {
            return $models;
        }
        $referencedModel = $relation->getReferencedModel();/*关联模型Common\Models\WeOrderGoods*/
        $referencedField = $relation->getReferencedFields();/*关联模型关联字段WeOrderGoods.orderid*/
        $primaryField = $relation->getFields();/*主模型字段Common\Models\WeOrder.id*/
        $primaryId = [];/*主模型的id*/

        foreach ($models as $model) {
            if (isset($model->$primaryField)) {
                $primaryId[] = $model->$primaryField;
            }
        }
        $primaryId = array_unique($primaryId);
        if (empty($primaryId)) {
            return $models;
        }

        if (count($primaryId) == 1) {
            $where = "$referencedField = " . current($primaryId);
        } else {
            $where = "$referencedField in (" . join(',', $primaryId) . ")";
        }
        if (empty($param[0])) {
            $param[0] = $where;
        } else {
            $param[0] .= " and " . $where;
        }
        $referencedResults = $referencedModel::find($param);
        $result = [];
        $relationType = $relation->getType();
        switch ($relationType) {
            case Model\Relation::HAS_ONE:
                foreach ($referencedResults as $referencedResult) {
                    $result[$referencedResult->$referencedField] = $referencedResult;
                }
                break;
            case Model\Relation::HAS_MANY:
                foreach ($referencedResults as $k => $referencedResult) {
                    $result[$referencedResult->$referencedField][] = $referencedResult;
                }
                break;
        }
        self::$modelRelationCache[static::class][$alias] = [
            'primaryField' => $primaryField,
            'data' => $result
        ];
        unset($result);
        unset($referencedResults);
        return $models;
    }

    public function __get($property)
    {
        $calledClass = get_class($this);
        if (isset(self::$modelRelationCache[$calledClass])) {
            $lowerProperty = strtolower($property);
            if (isset(self::$modelRelationCache[$calledClass][$lowerProperty])) {
                $thisAliasRelationCache = self::$modelRelationCache[$calledClass][$lowerProperty];/*当前别名下的所有模型记录*/
                $primaryField = $thisAliasRelationCache['primaryField'];
                $value = $this->$primaryField;
                if (isset($thisAliasRelationCache['data'][$value])) {
                    return $thisAliasRelationCache['data'][$value];
                }
            }
        }
        return parent::__get($property);
    }

    /**
     *  字段自增
     * @param null $field
     * @param string $step
     * @return bool
     */
    public function increment($field = null, $step = '')
    {
        $field = filter_var($field, FILTER_SANITIZE_STRING);
        $this->$field = $this->$field + (int)$step;
        return $this->save();
    }

    /**
     * 字段自减
     * @param null $field
     * @param string $step
     * @return bool
     */
    public function decrement($field = null, $step = '')
    {
        $field = filter_var($field, FILTER_SANITIZE_STRING);
        $this->$field = $this->$field - (int)$step;
        return $this->save();
    }

    /**
     * 执行原生sql
     * @param $conditions
     * @param null $bindParams
     * @param null $bindTypes
     * @return Simple
     */
    public static function findByRawSql($conditions, $bindParams = null, $bindTypes = null)
    {
        $model = new static();
        return new Simple(
            null,
            $model,
            $model->getReadConnection()->query($conditions, $bindParams, $bindTypes)
        );
    }

    /**
     * 获取字段的错误信息 一般用于验证错误产生的信息返回给前端展示用
     * @return array
     */
    public function getErrInput()
    {
        $errinput = [];
        $messages = $this->getMessages();
        if (empty($messages)) {
            return $errinput;
        }
        foreach ($messages as $message) {
            $field = $message->getField();
            $msg = $message->getMessage();
            if (isset($errinput[$field])) {
                $errinput[$field] .= $msg . "\r\n";
            } else {
                $errinput[$field] = $msg . "\r\n";
            }
        }
        return $errinput;
    }

    public static function getTableName()
    {
        $model = DiHelper::getDi()->get(static::class);
        return $model->getSource();
    }

    public static function rules()
    {
        return [
            'name'=>[
                'PresenceOf'=>new PresenceOf(['label'=>self::getLabel('name')])
            ]
        ];
    }
    public static function getRule($field,$ruleName='')
    {
        $rules=static::rules();
        if(isset($rules[$field])){
            $rules=$rules[$field];
        }else{
            return [];
        }
        if(empty($ruleName)){
            return $rules;
        }elseif(isset($rules[$ruleName])){
            return $rules[$ruleName];
        }else{
            return [];
        }

    }
    public static function  labels ()
    {
        return [];
    }
    public static function getLabel($field='',$defaultLabel='')
    {
        $allLabel=self::labels();
        if(isset($allLabel[$field])){
            return $allLabel[$field];
        }else{
            return $defaultLabel;
        }
    }

    /**
     * 检查字段值是否存在
     * @param $field
     * @return bool 存在返回true  不存在返回false
     */
    public function checkIsExist($field = '', $where = '', $bind = [])
    {
        if (empty($field) || !isset($this->$field) || $this->$field === null) {
            return true;
        }
        $condition = "$field = :fieldValue: ";
        if (!empty($this->id)) {
            $condition .= ' and id <> ' . $this->id;
        }
        if ($where) {
            $condition .= " and $where ";
        }
        $bind['fieldValue'] = $this->$field;
        $res = self::count([
            $condition,
            'bind' => $bind

        ]);
        return empty($res) ? false : true;
    }


    /**
     * 将单位为分的金额转成单位为元的金额
     * @param string $field
     * @return string
     */
    public function getMoney($field = '')
    {
        $value = $this->getModelValue($field, 0);
        return NumberHelper::renderMoney($value);
    }

    /**
     * unix时间戳转成Y-M-D H:i:s 格式
     * @param string $field
     * @param bool $onlyYMD 是否只要YMD
     * @return false|string
     */
    public function getTimeStr($field = '', $onlyYMD = false)
    {
        $value = $this->getModelValue($field, 0);
        return TimeHelper::changeIntToStr($value, $onlyYMD);
    }

    /**
     * 根据是否为空转化成Yes No
     * @param string $field
     * @return string
     */
    public function getYesOrNo($field = '')
    {
        $value = $this->getModelValue($field, false);
        return empty($value) ? 'No' : "Yes";
    }

    /**
     * 根据模型里的图片地址转成img 的html格式
     * @param string $field
     * @param string $width
     * @param string $height
     * @param string $style
     * @return string
     */
    public function getImgHtml($field = '', $width = '', $height = '', $style = '')
    {
        $value = $this->getModelValue($field, '');
        return Tag::image([
            $value,
            'alt' => $value,
            'width' => $width,
            'height' => $height,
            'style' => $style
        ]);
    }

    /**
     * 获取某个字段在模型里的值
     * @param string $field 字段名
     * @param int $default 默认值
     * @return int|Model\Resultset|\Phalcon\Mvc\Phalcon\Mvc\Model
     */
    protected function getModelValue($field = '', $default = 0)
    {
        return isset($this->$field) ? $this->$field : $default;
    }

    public function validateWithException($validator)
    {
        $res = parent::validate($validator);
        /*验证失败*/
        if (!$res) {
            $message = join("<br/>\r\n", $this->getMessages());
            throw new ValidationFailedException($message, [], $this->getErrInput());
        }
    }
    /**
     * 检查当前数据是否属于某个店铺
     * @param $comid
     * @param string $field
     * @return bool
     * @throws LogicException
     */
    public function checkIsBelongCom($comid, $field = 'comid',$message='')
    {
        if (isset($this->$field) && $this->$field === $comid) {
            return true;
        } else {
            $message=empty($message)?'您没有权限操作':trim($message);
            throw new LogicException($message);
        }
    }
    /**
     * 检查当前数据是否属于某个代理商
     * @param $comid
     * @param string $field
     * @return bool
     * @throws LogicException
     */
    public function checkIsBelongAgent($agentId=0, $field = 'agentid',$message='')
    {
        if (isset($this->$field) && $this->$field === $agentId) {
            return true;
        } else {
            $message=empty($message)?'您没有权限操作':trim($message);
            throw new LogicException($message);
        }
    }


    /**
     * 不能正确保存直接抛出异常
     * @param array $data
     * @param $whiteList
     * @return bool
     * @throws ModelExExecuteException
     */
    public function saveWithException($data=[],$whiteList=[],$message='')
    {
        if($this->save($data,$whiteList)){

            return true;
        }else{
            $errinput=$this->getErrInput();

            $message=empty($message)?$this->getMessagesStr("\r\n"):trim($message);
            $message=empty($message)?"保存失败":$message;
            throw new ModelExExecuteException($message,[],$errinput);
        }
    }

    /**
     * 获取拼接成字符串之后的信息
     * @param string $split
     * @return string
     */
    public function getMessagesStr($split="\r\n")
    {
        return join($split,$this->getMessages());
    }

    /**
     * 软删除
     * @param string $delField
     */
    public function softDel($delField='isdel')
    {
        $this->$delField=1;
        return $this->saveWithException();
    }


}