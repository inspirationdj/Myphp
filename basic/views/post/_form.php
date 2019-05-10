<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 8:53
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<?php

//查询构建器
?>
<div class="post-form">
    <?php $form=ActiveForm::begin();?>
    <?= $form->field($model,'tg_title')->textInput(['maxlength'=>true])?>
    <?= $form->field($model,'tg_content')->textInput(['rows'=>6])?>
    <?= $form->field($model,'tg_username')->textInput(['rows'=>6])?>
    <?= $form->field($model,'tg_date')->textInput()?>
    <?= $form->field($model,'tg_last_modify_date')->textInput()?>
    <div class="form-group">
        <?=Html::submitButton('保存',['class'=>'btn btn-success'])?>
    </div>
    <?php ActiveForm::end();?>

</div>
