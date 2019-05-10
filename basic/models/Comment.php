<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/29
 * Time: 15:07
 */
namespace app\models;
use Yii;
use yii\db\ActiveRecord;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'tg_comment';
    }
    public function rules()
    {
        return [
            [['tg_name','tg_content'],'required'],
            ['tg_id','integer'],
            ['tg_date','datetime'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'tg_id'=>'ID',
            'tg_content'=>'内容',
            'tg_date'=>'发表时间',
            'tg_name'=>'发表人',
        ];
    }
}