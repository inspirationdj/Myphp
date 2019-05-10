<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '注册界面';
?>
<div class="adminuser-register">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php $form = ActiveForm::begin() ?>
    <?= $form->field($model, 'username')->textInput(['placeholder' => "用户名"])->label('用户名') ?>
    <?= $form->field($model, 'password')->passwordInput()->label('密 码 ') ?>
    <?= $form->field($model, 'repassword')->passwordInput()->label('确认密码 ') ?>
    <?= $form->field($model, 'email')->textInput()->label('邮箱 ') ?>
    <?= Html::submitButton('注册') ?>
    <?php $form->end() ?>

</div>