<?php
use yii\helpers\Html;
$this->title='添加分类';
$this->params['breadcrumbs'][]=['label'=>'分类','url'=>['index']];
$this->params['breadcrumbs'][]=$this->title;
?>
<div class="article-create">
    <h1>
        <?=Html::encode($this->title)?>
    </h1>
    <?=$this->render('_form',[
            'model'=>$model,

            ])?>
</div>
