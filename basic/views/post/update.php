<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/27
 * Time: 17:44
 */
use yii\helpers\Html;
$this->title='更新文章:'.$model->tg_title;
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['index']];
$this->params['breadcrumbs'][]=['label'=>$model->tg_title,'url'=>['view','id'=>$model->tg_id]];
$this->params['breadcrumbs'][]='修改';
?>
<div class="post-update">
    <h1><?=Html::encode($this->title)?></h1>
    <?=$this->render('_form',['model'=>$model])?>
</div>
