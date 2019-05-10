<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/26
 * Time: 11:34
 */
use yii\helpers\Html;
use yii\grid\GridView;
$this->title='文章列表';
$this->params['breadcrumb'][]=$this->title;
?>
<div class="post-index">
        <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('新添文章',['create'],['class'=>'btn btn-success'])?>
    </p>
    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                    //['class'=>'yii\grid\SerialColumn'],
                    'tg_id',
                    'tg_title',
                    'tg_content',
                    'tg_username',
                    'tg_last_modify_date',
                [
                    'attribute' => 'tg_date',
                    'format' => ['date','php:Y-m-d H:i:s'],
                ],
                    ['class'=>'yii\grid\ActionColumn'],
            ],
    ]);?>
</div>
