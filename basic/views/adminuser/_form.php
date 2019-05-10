<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 15:50
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="login-form">
    <?php $form =ActiveForm::begin();?>
    <?= $form->field($model,'tg_username')->textInput(['maxlength'=>true])?>
    <?= $form->field($model,'tg_password')->passwordInput(['maxlength'=>true])?>
    <?= $form->field($model,'tg_qq')->textInput(['maxlength'=>true])?>
    <?= $form->field($model,'tg_email')->textInput(['maxlength'=>true])?>
    <div class="form-group">
        <?=Html::submitButton('保存',['class'=>'btn-success'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
