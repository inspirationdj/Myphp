<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 10:29
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
use yii\filters\auth\AuthMethod;
use yii\widgets\ActiveForm;

class AuthAssignment extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_assignment';
    }
    public function rules()
    {
        return [
            [['item_name','user_id'],'required'],
            ['created_at','integer'],
            [['item_name','user_id'],'string','max'=>64],
            [['item_name'],'exist','skipOnError'=>true,'targetClass'=>AuthItem::className(),'targetAttribute'=>['item_name'=>'name']],
        ];
    }
    public function attributesLabels()
    {
        return [
            'item_name'=>'Item Name',
            'user_id'=>'User ID',
            'created_at'=>'Create At',
        ];
    }

    public function getItemName()
    {
        return $this->hasOne(AuthItem::className(), ['name' => 'item_name']);
    }
}