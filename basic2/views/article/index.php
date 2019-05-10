<?php
/**
 * @var $dataProvider \yii\data\ActiveDataProvider
 * @var $searchModel
 */

use yii\helpers\Html;
use yii\grid\GridView;


$this->title='文章列表';
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="article-index">
    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('写文章',['create'],['class'=>'btn btn-success'])?>
    </p>
    <?=GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            [
                'attribute'=>'category_id',
                'value'=>'category.name',
                'filter' => \app\models\Category::find()
                    ->select('id','name')
                    ->from('category')
                    ->indexBy('id')
                    ->column(),
//                    Html::activeDropDownList($searchModel,'category_id',['0'=>'全部','1'=>'PHP','2'=>'Python','3'=>'Java']),

            ],
            'title',
            //'content',
            [
                    'attribute' => '状态',
                'value' => function($model) {
        /** @var $model \app\models\Article */
        return $model->statusName;
                },
                'filter' => \app\models\Article::$statusData,
            ],
            [
                'label'=>'标签',
                'value'=>function($model)
                {
                    $tags=$model->tags;
                    $arr=[];
                    foreach ($tags as $v)
                    {
                        $arr[]=$v['name'];
                    }
                    return implode(' ',$arr);

                }
            ],

//            [
//                    'attribute' => 'is_deleted',
//                    'value' => 'article_status.status',
//                    'filter' => \app\models\ArticleStatus::find()
//                    ->select('status','id')
//                    ->from('article_status')
//                    ->indexBy('id')
//                    ->column(),
//
//            ],

            //'create_at',
            [
                'attribute' => 'updated_at',
                'format' => ['date','php:Y-m-d H:i:s'],
            ],
            [
                'attribute' => 'created_at',
                'format' => ['date','php:Y-m-d H:i:s'],
            ],
            ['class'=>'yii\grid\ActionColumn'],
        ],
    ]);?>
</div>
