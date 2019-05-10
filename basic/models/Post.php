<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/27
 * Time: 13:28
 */
namespace app\models;
use yii\helpers\Html;
use Yii;
use yii\db\ActiveRecord;
    class Post extends ActiveRecord
    {
        public static function tableName()
        {
            return 'tg_article';
        }
        public function rules()
        {
            return [
                [['tg_title','tg_content'],'required'],
                ['tg_content','string'],
                ['tg_id','integer'],
                [['tg_title'],'string','max'=>40],

            ];
        }

        public function attributeLabels()
        {
            return [
                'tg_id'=>'ID',
                'tg_title'=>'标题',
                'tg_content'=>'内容',
                'tg_date'=>'创建时间',
                'tg_last_modify_date'=>'更新时间',
                'tg_username'=>' 作者 ',
            ];
        }
    }
