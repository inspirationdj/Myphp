<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 16:28
 */
use yii\helpers\Html;
$this->title='修改'.$model->tg_username;
$this->params['breadcrumbs'][]=['label'=>'管理员','url'=>['index']];
$this->params['breadcrumbs'][]=['label'=>$model->tg_username,'url'=>['view','id'=>$model->tg_id]];
$this->params['breadcrumbs'][]='修改';
?>
<div class="login-update">
    <h1><?=Html::encode($this->title)?></h1>
    <?=$this->render ('_form',['model'=>$model,])?>
</div>
