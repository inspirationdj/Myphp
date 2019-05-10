<?php

namespace app\models\form;

use Yii;
use yii\base\Model;
use app\models\Adminuser;

class RegisterForm extends Model
{
    public $username;
    public $password;
    public $repassword;
    public $email;

    public function rules()
    {
        return [
            [['username', 'password', 'repassword', 'email'], 'required'],
            [['username','password','email'], 'trim'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            [
                'username',
                'unique',
                'targetClass' => '\app\models\Adminuser',
                'targetAttribute' => 'username',
                'message' => '用户名已存在'
            ],
            [
                'email',
                'unique',
                'targetClass' => '\app\models\Adminuser',
                'targetAttribute' => 'email',
                'message' => '邮箱已存在'
            ],
            ['repassword', 'compare', 'compareAttribute' => 'password'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'username' => '用户名',
            'password' => '密码',
            'repassword' => '重复密码',
            'email' => '邮箱',
        ];
    }

    public function register()
    {
        if(!$this->validate()) {
            return false;
        }
        $user = new Adminuser();
        $user->username = $this->username;
        $user->savePassword($this->password);
        $user->email = $this->email;
        return $user->save()?$user:NULL;
//        $user->save();
//        echo $user->savePassword($this->password);
//        print_r($user->errors);exit;

    }
}