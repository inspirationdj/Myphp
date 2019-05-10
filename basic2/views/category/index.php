<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/4
 * Time: 18:02
 */
use yii\helpers\Html;
use yii\grid\GridView;
$this->title='分类管理';
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="category-index">
    <h1><?=Html::encode($this->title)?></h1>
    <p>
        <?=Html::a('新建标签',['create'],['class'=>'btn btn-success'])?>
    </p>
    <?=GridView::widget([
        'dataProvider'=>$dataProvider,
        'filterModel' => $searchModel,

          'columns'=>[
            'id',
            'name',
              [
                      'label' => '分类文章',
                      'value'=>function($model)
                      {
                          $article=$model->articles;
                          $arr=[];
                          foreach ($article as $v)
                          {
                              $arr[]=$v['title'];
                          }
                          return implode('|',$arr);
                      }
              ],
              ['class'=>'yii\grid\ActionColumn'],
        ],

    ]);?>
</div>