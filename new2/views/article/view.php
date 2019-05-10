<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\Article
 * */

use yii\helpers\Html;
use yii\widgets\DetailView;

$this->title = $model->title;
?>
<div class="article_view">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('修改', ['update', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
        <?= Html::a('删除', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => '确定删除',
                'method' => 'post',
            ],
        ]) ?>
    </p>
    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'content',
            [
                'label' => '作者',
                'value' => $model->getAdminuserName(),
            ],
            [
                'label' => '分类',
                'value' => $model->category->name,
            ],
            [
                'label' => '标签',
                'value' => implode(',', $model->getTagNames()),
            ],
            [
                'attribute' => '创建时间',
                'value' => date('Y-m-d H:i:s', $model->create_at),
            ],
            [
                'attribute' => '更新时间',
                'value' => date('Y-m-d H:i:s', $model->update_at),
            ],
        ],
    ]) ?>
</div>
