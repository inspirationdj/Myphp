<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/14
 * Time: 18:05
 */
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
//'enableAjaxValidation' => true
$form = ActiveForm::begin(['id' => 'signup-form','options' => ['class' => 'form-horizontal'],])?>
<h1>注册界面</h1>
<?=$form->field($model,'username') ?>
<?=$form->field($model,'password')->passwordInput()?>
<?=$form->field($model,'repassword')->passwordInput()?>
<?=$form->field($model,'email')?>
<?=$form->field($model,'qq')?>
<?= Html::submitButton('注册')?>
<?php ActiveForm::end(); ?>
