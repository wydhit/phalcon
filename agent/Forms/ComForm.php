<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-11
 * Time: 16:59
 */

namespace Agent\Forms;


use Common\Exception\LogicException;
use \Common\Forms\ComForm as BaseComForm;

class ComForm extends BaseComForm
{
    public static function addForm($entity = null, $userOptions = null)
    {
        $agentid=isset($userOptions['agentid'])?$userOptions['agentid']:0;
        $comUserId=isset($userOptions['comUserId'])?$userOptions['comUserId']:0;
        if(empty($agentid)){
            throw new LogicException('表单必须指明agentid');
        }
        $form=new self($entity,$userOptions);
        $form->addComUser($agentid,$comUserId);
        $form->addIc();
        $form->addTitle();
        return $form;
    }

}