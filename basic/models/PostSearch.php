<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/27
 * Time: 13:28
 */
namespace app\models;
use yii\base\model;
use yii\data\ActiveDataProvider;

class PostSearch extends Post
{
    public function rules()
    {
        return [
            ['tg_id','integer'],
            [['tg_title','tg_content','tg_username'],'safe'],
        ];
    }
    public function attributeLabels()
    {
        return [
            'tg_id'=>'ID',
            'tg_title'=>'标题',
            'tg_content'=>'内容',
            'tg_last_modify_date'=>'更新时间',
            'tg_date'=>'创建时间',
            'tg_username'=>'作者',
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query=Post::find();
        $dataProvider=new ActiveDataProvider([
            'query' => $query,
            'pagination' => ['pageSize'=>5],
            'sort'=>[
                'defaultOrder'=>[
                    'tg_id'=>SORT_ASC,
                ],
            ],
        ]);
        $this->load($params);
        if(!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'tg_id'=>$this->tg_id,
            'tg_date'=>$this->tg_date,
            'tg_last_modify_date'=>$this->tg_last_modify_date,
            'tg_username'=>$this->tg_username,


        ]);
        $query->andFilterWhere(['like','tg_title',$this->tg_title])
              ->andFilterWhere(['like','tg_content',$this->tg_content]);

        return $dataProvider;
    }

}