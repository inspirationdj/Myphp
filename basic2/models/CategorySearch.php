<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/8
 * Time: 9:09
 */
namespace app\models;
use Yii;
use yii\base\model;
use yii\data\ActiveDataProvider;
class CategorySearch extends Category
{
    public function rules()
    {
        return [
            [['id', 'name'], 'required'],
            ['id', 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            '分类ID' => 'id',
            '分类名称' => 'name'
        ];
    }

    public function scenarios()
    {
        return Model::scenarios();
    }
    public function search($params)
    {
        $query = Category::find();
        $dataProvider=new ActiveDataProvider([
            'query' => $query,
//           'pagination' => 5,
//            'sort' => [
//                'defaultOrder'=>[
//                    'id'=>SORT_ASC,
//                ],
//            ],
        ]);
        $this->load($params);
        if(!$this->validate())
        {
            return $dataProvider;
        }
        $query->andFilterWhere([
            'id'=>$this->id,
            'name'=>$this->name,
        ]);
        return $dataProvider;

    }
}