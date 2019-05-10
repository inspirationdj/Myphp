<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/15
 * Time: 8:50
 */
namespace app\models;
use Yii;
use yii\base\Model;
use app\models\Login;

class SignupForm extends Model
{
public $username;
public $password;
public $email;
public $qq;
public $repassword;

public function rules()
{
    return  [
                [['username','password','email','qq'],'required'],
                [['username','password','email'],'trim'],
                ['username','string','min'=>2,'max'=>255],
                ['password','string','min'=>6,'max'=>12],
                ['email','email'],
                ['qq','integer'],
//                [['username', 'password'], 'unique', 'targetAttribute' => ['a1', 'a2']],
                ['username','unique','targetClass'=>'\app\models\Login','targetAttribute' => 'tg_username','message'=>'用户名已存在'],
                ['email','unique','targetClass'=>'\app\models\Login','targetAttribute' => 'tg_email','message'=>'邮箱已存在'],
                ['qq','unique','targetClass'=>'\app\models\Login','targetAttribute' => 'tg_qq','message'=>'QQ已存在'],
                ['repassword','compare','compareAttribute' => 'password'],
                //['verificationCode', 'captcha'],


    ];
}
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => '用户名',
            'password'=>'密码',
            'email'=>'邮箱',
            'qq'=>'qq',
            'repassword'=>'重复密码',


        ];
    }
public function signup()
{
        if(!$this->validate())
        {
            return null;
        }
        $user= new Login();
        $user->tg_username=$this->username;
        $user->setPassword($this->password);
        $user->tg_email=$this->email;
        $user->tg_qq=$this->qq;
        $user->tg_reg_time=date("Y-m-d H:i:s");
        return $user->save()?$user:null;

}



}
