<?php
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$form = ActiveForm::begin(['id' => 'login-form','options' => ['class' => 'form-horizontal'],])?>
<h1>登录界面</h1>
<?= $form->field($model, 'username')->textInput(['placeholder' => "用户名"])->label('用户名') ?>
<?= $form->field($model, 'password')->passwordInput()->label('密 码 ' ) ?>
<?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-6">{input}</div></div>',
]) ?>
<?= Html::submitButton('登录') ?>
<?php ActiveForm::end() ?>

