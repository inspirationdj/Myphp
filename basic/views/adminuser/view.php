<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 16:06
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title=$model->tg_username;
$this->params['breadcrumbs'][]=['label'=>'管理员','url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="login-view">
    <h1><?= Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('修改',['update','id'=>$model->tg_id],['class'=>'btn btn-primary'])?>
        <?=Html::a('删除',['adminuser/delete','id'=>$model->tg_id],[
            'class'=>'btn btn-danger',
            'data'=>[
                'confirm'=>'你确定要删除这条信息吗？',
                'method'=>'post',
            ],
            ])?>
    </p>
    <?=DetailView::widget([
        'model'=>$model,
        'attributes'=>[
            'tg_id'=>'ID',
            'tg_username',
            'tg_password',
            'tg_email',
            'tg_qq',
        ],
    ])?>
</div>