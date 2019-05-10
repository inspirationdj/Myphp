<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 15:58
 */
use yii\helpers\Html;
$this->title='添加管理员';
$this->params['breadcrumbs'][]=['label'=>'添加管理员','url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="login-create">
    <h1><?= Html::encode($this->title)?></h1>
    <?= $this->render('_form',[
        'model'=>$model,
    ])?>
</div>
