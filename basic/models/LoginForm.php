<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $username;
    public $password;
    public $verifyCode;
//    public $rememberMe = true;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
            ['verifyCode', 'captcha','message'=>'验证码不正确'],
            //['email','email'],
            //[['email','qq'],'required'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password'=>'密码',
            'verifyCode'=>'验证码',

        ];
    }


    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute,$params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

//            if (!$user || !$user->validatePassword($this->password)) {
//                $this->addError($attribute, 'Incorrect username or password.');
//            }


            if (!$user)
            {
                $this->addError($attribute, 'Incorrect username .');
                return false;
            }
            if(!$user->validatePassword($this->password))
            {
                $this->addError($attribute, 'Incorrect  password.');
                return false;
            }

        }

    }


    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());

        }
        return false;
    }


    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Login::findByUsername($this->username);

        }
        return $this->_user;
    }
}
