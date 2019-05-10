<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel
 */

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Article;
use app\models\Category;
use app\models\Adminuser;

$this->title = '文章列表';
?>
<div class="article-index">
    <h1><?= Html::encode($this->title) ?></h1>
    <p>
        <?= Html::a('写文章', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'caption'=>"文章列表",
        'columns' => [
            'id',
            'title',

            [
                'attribute' => 'aid',
                'value' => 'adminuser.username',
                'filter' => Adminuser::find()
                    ->select('id', 'username')
                    ->from('adminuser')
                    ->indexBy('id')
                    ->column(),
                'contentOptions' => ['style' => 'color:blue'],
            ],
            [
                'attribute' => 'category_id',
                'value' => 'category.name',
                'filter' => Category::find()
                    ->select('id', 'name')
                    ->from('category')
                    ->indexBy('id')
                    ->column(),
            ],

            [
                'attribute' => '文章状态',
                'value' => function ($model) {
                    return $model->statusNames;
                },
                'filter' => Article::$statusData,
            ],
            [
                'label' => '标签',
                'value' => function ($model) {
                    $tags = $model->tags;
                    $tag = [];
                    foreach ($tags as $v) {
                        $tag[] = $v['name'];
                    }
                    return implode(',', $tag);
                },
                'headerOptions' => ['style' => 'color:red'],
            ],

            [
                'attribute' => 'update_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'create_at',
                'format' => ['date', 'php:Y-m-d H:i:s'],
            ],
            ['class' => 'yii\grid\ActionColumn'],
        ],

    ]) ?>
</div>

