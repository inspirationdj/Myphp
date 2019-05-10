<?php
use yii\helpers\Html;

$this->title = '添加分类';
?>
<div class="category-create">
    <h1>
        <?=Html::encode($this->title)?>
    </h1>
    <?=$this->render ('_form',[
        'model'=>$model,
    ])?>
</div>
