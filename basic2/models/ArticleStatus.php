<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 9:22
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;
 class ArticleStatus extends ActiveRecord{
     public static  function tableName()
     {
         return'article_status';
     }
     public function rules()
     {
         return [
             ['id','integer'],
             [['id','status'],'required'],
         ];
     }
     public function attributeLabels()
     {
         return [
             'id'=>'ID',
             'status'=>'状态',
         ];
     }

     public function getIsdeleted()
     {
         return $this->hasMany(Article::className(),['is_deleted'=>'id']);
     }
 }