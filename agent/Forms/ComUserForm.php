<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-12
 * Time: 8:31
 */

namespace Agent\Forms;

use Common\Forms\UserForm;


class ComUserForm extends UserForm
{

    public static function addForm($entity = null, $userOptions = null)
    {
        $form=new self($entity,$userOptions);
        $form->addUName();
        $form->addUNick();
        $form->addUPhone();
        $form->addUMobile();
        $form->addUMail();
        $form->addUPass();
        $form->addUPassC();
        return $form;
    }

    public static function editForm($entity = null, $userOptions = null)
    {
        $form=new self($entity,$userOptions);
        $form->addUName(['readonly'=>true,'afterInput'=>'用户名不修改']);
        $form->addUNick();
        $form->addUPhone();
        $form->addUMobile();
        $form->addUMail();
        return $form;
    }

    public static function passWordForm($entity = null, $userOptions = null)
    {
        $form=new self($entity,$userOptions);
        $form->addUPass();
        $form->addUPassC();
        return $form;

    }



}