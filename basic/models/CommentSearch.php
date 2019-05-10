<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/29
 * Time: 15:07
 */
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Comment;

class CommentSearch extends Comment
{
//    public function attributes()
//    {
//        return array_merge(parent::attributes(),['']);
//    }
public function rules()
{
    return [
        [['tg_id','tg_date'],'integer'],
        [['tg_name','tg_content'],'safe'],
    ];
}
public function sceanrios()
{
    return Model::scenarios();
}
public function search($params)
{

}
}
