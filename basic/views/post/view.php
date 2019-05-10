<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/27
 * Time: 17:00
 */
use yii\helpers\Html;
use yii\widgets\DetailView;
$this->title=$model->tg_title;
$this->params['breadcrumbs'][]=['label'=>'文章管理','url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="post-view">
    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('修改',['update','id'=>$model->tg_id],['class'=>'btn btn-primary'])?>
        <?=Html::a('删除',['delete','id'=>$model->tg_id],[
            'class'=>'btn btn-danger',
            'data'=>[
                'confirm'=>'确定删除这篇文章？',
                'method'=>'post',
            ],
        ])?>
    </p>
    <?=DetailView::widget([
        'model'=>$model,
        'attributes' => [
            'tg_id',
            'tg_title',
            'tg_username',
            'tg_content',
            'tg_date',
            'tg_last_modify_date',

        ],
    ])?>
</div>
