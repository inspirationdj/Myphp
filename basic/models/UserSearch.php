<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Login;

/**
 * UserSearch represents the model behind the search form of `app\models\Login`.
 */
class UserSearch extends Login
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['tg_id', 'integer'],
            [['tg_username', 'tg_password', 'tg_email', 'tg_qq'], 'safe'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'tg_id' => 'ID',
            'tg_username' => '用户名',
            'tg_password' => '密码',
            'tg_qq' => 'QQ',
            'tg_email' => '邮箱',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Login::find()->where(['tg_level' => 0]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'tg_id' => $this->tg_id,
            //'tg_switch' => $this->tg_switch,
            //'tg_reg_time' => $this->tg_reg_time,
            //'tg_last_time' => $this->tg_last_time,
            //'tg_level' => $this->tg_level,
            //'tg_login_count' => $this->tg_login_count,
        ]);

        $query->andFilterWhere(['like', 'tg_username', $this->tg_username])
            ->andFilterWhere(['like', 'tg_password', $this->tg_password])
            ->andFilterWhere(['like', 'tg_email', $this->tg_email])
            ->andFilterWhere(['like', 'tg_qq', $this->tg_qq]);

        return $dataProvider;
    }
}
