<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 14:47
 */
use yii\helpers\Html;
use yii\grid\GridView;
use basic\views\ActionColumn;
use yii\widgets\pjax;

$this->title='管理员';
$this->params['breadcrumbs'][]=$this->title;
?>

<div class="login-index">
    <h1><?= Html::encode($this->title)?></h1>
    <?php //echo $this->render('_search',['model'=>$searchModel]);?>
    <p>
        <?= Html::a('添加管理员',['create'],['class'=>'btn btn-success'])?>
    </p>
    <?=GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns'=>[
                    ['class'=>'yii\grid\SerialColumn'],
                    'tg_id',
                    'tg_username',
                    //'tg_password',
                    'tg_email',
                    'tg_qq',
                    [
                     'label'=>'权限',
                     'value'=>function($model)
                     {
                         $permissions = $model->permission;
                         $str = [];
                         foreach ($permissions as $permission) {
                             $str[] = $permission['item_name'];
                         }
                         return implode('|', $str);
                     }
                    ],
                    [
                    'label'=>'用户（邮箱）',
                    'value'=>function($model)
                    {   if($model->tg_email!=='') {
                        return "{$model->tg_username}({$model->tg_email})";
                    }else{
                        return "{$model->tg_username}";
                    }
                    }
                    ],

            ['class'=>'yii\grid\ActionColumn',
                    'template' => '{view} {update} {delete} {resetpwd} {privilege}',
                    'buttons' => [
                            'resetpwd'=>function ($url,$model,$key)
                            {
                                $options=[
                                        'title'=>Yii::t('yii','重置密码'),
                                        'aria-label'=>Yii::t('yii','重置密码'),
                                        'data-pjax'=>'0',
                                ];
                                return Html::a('<span class="glyphicon glyphicon-lock"></span>',$url,$options);
                            },
                            'privilege'=>function ($url,$model,$key)
                            {
                                $options=[
                                        'title'=>Yii::t('yii','权限'),
                                        'aria-label'=>Yii::t('yii','权限'),
                                        'data-pjax'=>'0',
                                ];
                                return Html::a('<span class="glyphicon glyphicon-user"></span>',$url,$options);
                            },
                    ],
            ],
            ],
    ]);?>
</div>
