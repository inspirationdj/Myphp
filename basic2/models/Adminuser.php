<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 9:55
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class adminuser extends  ActiveRecord{
    public static function tableName()
    {
        return 'adminuser';
    }
    public  function rules()
    {
        return[
            ['id','integer'],
            [['id','username','password'],'required'],
        ];
    }
    public function attributes()
    {
        return [
            'id'=>'ID',
            'username'=>'用户名',
            'password'=>'密码',
        ];
    }

}