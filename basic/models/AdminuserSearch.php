<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 14:46
 */
namespace app\models;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Login;

class AdminuserSearch extends Login
{
    public function rules()
    {
        return [
            [['tg_id','tg_qq','tg_level'],'integer'],
            [['tg_permission','tg_reg_time','tg_id','tg_username','tg_password','tg_email','tg_qq'],'safe'],
        ];
    }
    public function scenarios()
    {
        return Model::scenarios();
    }

    public function search($params)
    {
        $query=Login::find()->where(['tg_level'=>1]);
        $dataProvider=new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);

        if(!$this->validate())
        {
            return $dataProvider;
        }

        $query->andFilterWhere(['like','tg_id',$this->tg_id])
              ->andFilterWhere(['like','tg_username',$this->tg_username])
              ->andFilterWhere(['like','tg_password',$this->tg_password])
              ->andFilterWhere(['like','tg_email',$this->tg_email])
              ->andFilterWhere(['like','tg_qq',$this->tg_qq])
              ->andFilterWhere(['like','tg_reg_time',$this->tg_reg_time])
              ->andFilterWhere(['like','tg_permission',$this->tg_permission])
              ->andFilterWhere(['like','tg_level',$this->tg_level]);
        return $dataProvider;
    }
}
