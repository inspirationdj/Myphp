<?php

namespace app\models;

use app\models\Article;
use yii\data\ActiveDataProvider;
use yii\base\model;

class ArticleSearch extends Article
{
    public function rules()
    {
        return [
//            [['id','title','content','category_id','create_at','update_at','status'],'required'],
            [['title', 'content'], 'string'],
            [['id', 'category_id', 'create_at', 'update_at', 'status'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '文章标题',
            'content' => '文章内容',
            'category_id' => '分类ID',
            'status' => '文章状态',
            'create_at' => time(),
            'update_at' => time(),
        ];
    }

    public function search($params)
    {
        $query = Article::find()->where(['aid'=>\Yii::$app->user->identity->getId()]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'category_id' => $this->category_id,
            'status' => $this->status,
            'create_at' => $this->create_at,
            'update_at' => $this->update_at,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);
        return $dataProvider;
    }
}