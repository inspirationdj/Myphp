<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\UserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="login-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'tg_id') ?>

<!--   <?//= $form->field($model, 'tg_uniqid') ?> -->

    <!--  <?= $form->field($model, 'tg_active') ?> -->

    <?= $form->field($model, 'tg_username') ?>

    <!--  <?= $form->field($model, 'tg_password') ?> -->

    <?php // echo $form->field($model, 'tg_question') ?>

    <?php // echo $form->field($model, 'tg_answer') ?>

    <?php // echo $form->field($model, 'tg_email') ?>

    <?php // echo $form->field($model, 'tg_qq') ?>

    <?php // echo $form->field($model, 'tg_url') ?>

    <?php // echo $form->field($model, 'tg_sex') ?>

    <?php // echo $form->field($model, 'tg_face') ?>

    <?php // echo $form->field($model, 'tg_switch') ?>

    <?php // echo $form->field($model, 'tg_autograph') ?>

    <?php // echo $form->field($model, 'tg_reg_time') ?>

    <?php // echo $form->field($model, 'tg_last_time') ?>

    <?php // echo $form->field($model, 'tg_last_ip') ?>

    <?php // echo $form->field($model, 'tg_level') ?>

    <?php // echo $form->field($model, 'tg_login_count') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
