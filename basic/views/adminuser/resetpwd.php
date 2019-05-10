<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/25
 * Time: 16:16
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '重置密码';
$this->params['breadcrumbs'][] = ['label' => '管理员', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="adminuser-resetpwd">
    <h1><?= Html::encode($this->title) ?></h1>
    <div class="adminuser-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password_repeat')->passwordInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('修改', ['class' => 'btn btn-success']) ?>

        </div>
        <?php  ActiveForm::end(); ?>
    </div>
</div>

