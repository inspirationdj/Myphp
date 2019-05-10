<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 9:53
 */
use yii\helpers\Html;
$this->title='添加文章';
$this->params['breadcrumbs'][]=['label'=>'文章','url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="post-create">
    <h1>
        <?=Html::encode($this->title)?>
    </h1>
    <?=$this->render('_form',['model'=>$model,])?>
</div>
