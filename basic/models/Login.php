<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/5
 * Time: 16:55
 */

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\base\NotSupportedException;

class Login extends ActiveRecord implements IdentityInterface
{
    public $username;
    public $password;
    public $email;
    public $qq;
    public $level;



    public static function tableName()
    {
        return 'tg_user';
    }
    public function rules()
    {
        return [
            [['tg_username','tg_password'],'required'],
            [['tg_qq','tg_qq','tg_level'],'integer'],
            ['tg_email','email'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tg_id' => 'ID',
            'tg_username' => '用户名',
            'tg_password'=>'密码',
            //'auth_key' => 'Auth Key',
            //'password_hash' => 'Password Hash',
            //'password_reset_token' => 'Password Reset Token',
            'tg_email' => 'Email',
            //'status' => '状态',
            //'created_at' => '创建时间',
            //'updated_at' => '修改时间',
            'tg_qq'=>'QQ',
            'tg_level'=>'权限',
            'tg_reg_time'=>'注册时间',
            'tg_permission'=>'权限',
        ];
    }

    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public static function findByUsername($username)
    {
        return static::findOne(['tg_username'=>$username]);
    }

    public function getId()
    {
        return $this->tg_id;
    }

    public function getAuthKey()
    {
        return $this->authKey;
    }

    public function getPermission()
    {
        return  $this->hasMany(AuthAssignment::className(),['user_id'=>'tg_id'])->asArray();

    }

    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;

    }

    public  function validatePassword($password)
    {
        if (!!Yii::$app->getSecurity()->validatePassword($password,$this->tg_password))
        {
            return true;
        }
        return false;
    }
    public function setPassword($password)
{
    return $this->tg_password=Yii::$app->security->generatePasswordHash($password);
}
    public function permission()
    {
        $adminuser=$this->find()->where(['tg_level'=>1])->all();
        foreach ($adminuser as $val)
            {
                $permissions=$val->getPermission();

            }
            return $permissions;
    }

}

