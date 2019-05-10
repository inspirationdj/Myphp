<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 10:44
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class AuthItem extends ActiveRecord
{
    public static function tableName()
    {
        return 'auth_item';
    }
    public function rules()
    {
        return [
            [['name','type'],'required'],
            [['type','created_at','update_at'],'integer'],
            [['description','data'],'string'],
            [['name','rule_name'],'string','max'=>64],
            [['rule_name'],'exist','skipOnError' => true,'targetClass' => AuthRule::className(),'targetAttribute' => ['rule_name'=>'name']],
        ];
    }
    public function getAuthAssignments()
    {
        return $this->hasMany(AuthAssignment::className(),['item_name'=>'name']);
    }
    public function getRuleName()
    {
        return $this->hasOne(AuthRule::className(),['name'=>'rule_name']);
    }
    public function getAuthItemChildren()
    {
        return $this->hasMany(AuthItem::className(),['name'=>'child'])->viaTable('auth_item_child', ['parent' => 'name']);
    }
    public function getParents()
    {
        return $this->hasMany(AuthItem::className(),['name'=>'parent'])->viaTable('auth_item_child', ['child' => 'name']);
    }
}