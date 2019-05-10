<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '登录界面';
?>
<div class="adminuser-login">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username')->textInput(['placeholder' => "用户名"])->label('用户名') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('密 码 ') ?>
    <?= Html::submitButton('登录') ?>
    <?php $form->end() ?>

</div>
