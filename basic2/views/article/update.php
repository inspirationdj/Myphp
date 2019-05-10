<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 10:51
 */
use yii\helpers\Html;

$this->title='更新文章: '.$model->title;
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['index']];
$this->params['breadcrumbs'][]=['label'=>$model->title,'url'=>['view','id'=>$model->id]];
$this->params['breadcrumbs'][]='修改';
?>
<div class="article-update">
    <h1><?=Html::encode($this->title);?></h1>
    <?= $this->render('_form', [
        'model' => $model,

    ]) ?>
</div>
