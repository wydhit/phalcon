<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-12
 * Time: 14:07
 */

namespace Common\Forms;


use Common\Models\WeCom;
use Common\Models\WeUser;
use Phalcon\Forms\Element\Select;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Alnum;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;

class ComForm extends BaseForm
{

    
    public function addComUser($agentid = 0, $comUserId = 0)
    {
        $modelWhere = 'isdel=0 and u_gic="bizer" and u_roleic="sys"';
        if ($agentid) {
            $agentid = (int)$agentid;
            $modelWhere .= " and  agentid =$agentid";
        }
        $uid = new Select(
            'uid',
            WeUser::find([$modelWhere]),
            [
                'using' => [
                    'id',
                    'u_nick',
                ],
                'useEmpty' => true,
                'emptyText' => "请选择商家用户",
                'emptyValue' => 0,
                'value' => $comUserId
            ]
        );
        $uid->setLabel('商家用户')
            ->addValidators([
                new PresenceOf(['message' => '必须选择商家用户'])
            ]);
        $this->add($uid);
    }

    public function addIc()
    {
        $ic = new Text('ic');
        $ic->setLabel('店铺编号')
            ->addValidators([
                new PresenceOf(['message' => '店铺编号不能为空']),
                new Alnum(['只能包含数字字母']),
                new StringLength(['max' => 30])
            ]);
        $this->add($ic);
    }

    public function addTitle()
    {
        $title = new Text('title');
        $title->setLabel('店铺名称')
            ->addValidators([
                new PresenceOf(['message' => '店铺名称不能为空']),
                new StringLength(['min' => 3, 'max' => 50])
            ]);
        $this->add($title);
    }

    public function addMylocation()
    {
        $mylocation = new Text('mylocation');
        $mylocation->setLabel('店铺地址')
            ->addValidators([
                new PresenceOf(['message' => '店铺地址不能为空']),
                new StringLength(['max' => 255])
            ]);
        $this->add($mylocation);
    }

    public function addTelfront()
    {
        $telfront = new Text('telfront');
        $telfront->setLabel('前台电话')
            ->addValidators([
                new PresenceOf(['message' => '前台电话不能为空'])
            ]);
        $this->add($telfront);
    }


}