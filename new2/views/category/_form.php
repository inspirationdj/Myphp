<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="category-form">
    <?php $form=ActiveForm::begin() ?>
    <?= $form->field($model,'name')->textInput()?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>


