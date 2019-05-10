<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Login */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'tg_username')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tg_password')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tg_email')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tg_qq')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
