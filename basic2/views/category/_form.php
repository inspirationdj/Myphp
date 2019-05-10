<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/8
 * Time: 11:31
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="category-form">
    <?php $form=ActiveForm::begin();?>
    <?= $form->field($model,'name')->textInput()?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>
