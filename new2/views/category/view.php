<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
/**
 *@var $model \app\models\Category
 *@var $this \yii\web\View
 */
$this->title = '查看分类:'.$model->name;
?>
<div class="category-view">
    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('修改',['update','id'=> $model->id],['class' => 'btn btn-success'])?>
        <?=Html::a('删除',['delete','id' => $model->id],[
            'class' => 'btn btn-danger',
            'date' => [
                'confirm' => '确认删除？',
                'method' => 'post',
            ],
        ])?>
    </p>
    <?=DetailView::widget([
        'model'=>$model,
        'attributes' => [
            'id',
            'name',
            [
                'label' => '分类文章',
                'value' => implode(',', $model->getArticleNames()),
            ],
        ],
    ])?>
</div>
