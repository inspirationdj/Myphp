<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 8:55
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
class Category extends ActiveRecord
{
    public static function tableName()
    {
        return 'category';
    }

    public function rules()
    {
        return[
            ['id','integer'],
            ['name','required'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id'=>'ID',
            'name'=>'分类名称',
        ];
    }

    public function getArticles()
    {
        return $this->hasMany(Article::className(),['category_id'=>'id']);
    }
}