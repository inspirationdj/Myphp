<?php
use yii\helpers\Html;

$this->title = '修改';
?>
<div class="category-update">
    <h1>
        <?=Html::encode($this->title)?>
    </h1>
    <?=$this->render ('_form',[
        'model'=>$model,
    ])?>
</div>