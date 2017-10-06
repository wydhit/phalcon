<?php
/**
 * Created by PhpStorm.
 * User: wyd
 * Date: 2017-09-12
 * Time: 8:42
 */

namespace Common\Forms;


use Common\Models\WeUser;
use Common\Validator\MobileValidator;
use Phalcon\Forms\Element\Password;
use Phalcon\Forms\Element\Text;
use Phalcon\Validation\Validator\Confirmation;
use Phalcon\Validation\Validator\Email;
use Phalcon\Validation\Validator\PresenceOf;
use Phalcon\Validation\Validator\StringLength;


class UserForm extends BaseForm
{
    /**
     * 增加u_name元素
     */

    public function addUName($attributes=[])
    {

        $label = "用户名";
        $u_name = new Text('u_name',$attributes);
        $u_name->setLabel($label)
            ->addValidators([
                new PresenceOf(['message' => '用户名不能为空', 'label' => $label]),
                new StringLength(['max' => 50, 'min' => 3])
            ]);
        $this->add($u_name);
    }

    /**
     * 增加u_nick元素
     */
    public function addUNick()
    {
        $u_nick = new Text('u_nick');
        $u_nick->setLabel('昵称')
            ->addValidators([
                new PresenceOf(['message' => '昵称不能为空']),
                new StringLength(['max' => 50])
            ]);
        $this->add($u_nick);
    }

    /**
     *增加u_phone 元素
     */
    public function addUPhone()
    {
        $u_phone = new Text('u_phone');
        $u_phone->setLabel('联系电话')
            ->addValidators([
                new StringLength(['max' => 20, 'allowEmpty' => true])
            ]);
        $this->add($u_phone);
    }

    /**
     * 增加手机号u_mobile元素
     */
    public function addUMobile()
    {
        $u_mobile = new Text('u_mobile');
        $u_mobile->setLabel('手机号')
            ->addValidators([
                new PresenceOf(['message' => '手机号不为空']),
                new MobileValidator()
            ]);
        $this->add($u_mobile);
    }

    /**
     * 增加邮箱u_mail元素
     */
    public function addUMail()
    {
        $u_email = new Text('u_mail');
        $u_email->setLabel('邮箱')
            ->addValidators([
                new Email(['allowEmpty' => true])
            ]);
        $this->add($u_email);
    }

    public function addUPass()
    {
        $u_pass = new Password('u_pass');
        $u_pass->setLabel('密码')
            ->addValidators([
                new PresenceOf(['message' => '密码不能为空']),
                new StringLength(['min' => 6, 'message' => '密码长度不能小于6位']),
                new Confirmation(['with' => 'u_pass_c', 'message' => '密码,确认密码必须一致'])
            ]);
        $this->add($u_pass);
    }

    public function addUPassC()
    {
        $u_pass_c = new Password('u_pass_c');
        $u_pass_c->setLabel('确认密码')
            ->addValidators([
                new PresenceOf(['message' => '确认密码不能为空']),
                new StringLength(['min' => 6, 'messageMinimum' => '确认密码长度不能小于6位']),
                new Confirmation(['with' => 'u_pass', 'message' => '密码,确认密码必须一致'])
            ]);
        $this->add($u_pass_c);
    }
}