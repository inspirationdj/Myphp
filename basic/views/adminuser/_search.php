<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 16:39
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>
<div class="login-search">
    <?php $form=ActiveForm::begin([
        'action'=>['index'],
        'method' => 'get',
    ]);?>
    <?=$form->field($model,'tg_id')?>
    <?=$form->field($model,'tg_username')?>
    <?=$form->field($model,'tg_qq')?>
    <?=$form->field($model,'tg_email')?>
    <div class="form-group">
        <?=Html::submitButton('查找',['class'=>'btn bth btn-primary'])?>
        <?=Html::submitButton('重置',['class'=>'btn btn btn-default'])?>
    </div>
    <?php ActiveForm::end();?>
</div>
