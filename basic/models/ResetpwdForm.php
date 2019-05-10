<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/25
 * Time: 18:11
 */
namespace app\models;
use yii\base\Model;
use app\models\Login;
use yii\helpers\VarDumper;

class ResetpwdForm extends Model
{
    public $password;
    public $password_repeat;

    public function rules()
    {
        return [
            ['password','required'],
            ['password','string','min'=>6],
            ['password_repeat','compare','compareAttribute'=>'password','message'=>'两次输入不一致'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'password'=>'密码',
            'password_repeat'=>'重置密码',
        ];
    }

    public function resetPassword($id)
    {
        if(!$this->validate())
        {
            return null;
        }
        $adminuser=Login::findOne($id);
        $adminuser->setPassword($this->password);
        return $adminuser->save()?true:false;
    }
}