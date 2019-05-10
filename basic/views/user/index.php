<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\UserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '用户管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="login-index">


    <h1><?= Html::encode($this->title) ?></h1>
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('新建用户', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'tg_id',
            //'tg_uniqid',
            //'tg_active',
            'tg_username',
            'tg_password',
            //'tg_question',
            //'tg_answer',
            'tg_email:email',
            'tg_qq',
            //'tg_url:url',
            //'tg_sex',
            //'tg_face',
            //'tg_switch',
            //'tg_autograph',
            //'tg_reg_time',
            //'tg_last_time',
            //'tg_last_ip',
            //'tg_level',
            //'tg_login_count',
            //'auth_key',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
