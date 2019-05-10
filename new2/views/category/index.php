<?php
use yii\helpers\Html;
use yii\grid\GridView;

$this->title = '分类管理';
?>
<div class="category-index">
    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('新建分类',['create'],['class' => 'btn btn-success'])?>
    </p>
    <?=GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'name',
            ['class'=>'yii\grid\ActionColumn'],
        ],
    ]);?>
</div>

