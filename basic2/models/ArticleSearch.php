<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/3
 * Time: 15:34
 */

namespace app\models;

use Yii;
use app\models\Article;
use yii\base\model;
use yii\data\ActiveDataProvider;

class ArticleSearch extends Article
{
    public function rules()
    {
        return [
            [['id', 'category_id', 'created_at', 'updated_at', 'is_deleted'], 'integer'],
            [['title', 'content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => '标题',
            'content' => '内容',
            'category_id' => '分类',
            'is_deleted' => '是否删除',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query = Article::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//           'pagination' => 5,
//            'sort' => [
//                'defaultOrder'=>[
//                    'id'=>SORT_ASC,
//                ],
//            ],
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id' => $this->id,
            'is_deleted' => $this->is_deleted,
            'category_id' => $this->category_id,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at,

        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'content', $this->content]);
        return $dataProvider;

    }

}