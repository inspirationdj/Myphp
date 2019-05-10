<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/3
 * Time: 16:27
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$allCategory_id=(new \yii\db\Query())
->select(['name','id'])
->from('category')
->indexBy('id')
->column();
$status=(new \yii\db\Query())
->select(['status','id'])
->from('article_status')
->indexBy('id')
->column();
?>
<div class="article-form">
    <?php $form=ActiveForm::begin();?>
    <?= $form->field($model,'title')->textInput()?>
    <?= $form->field($model,'content')->textarea(['rows' => 6])?>
    <?= $form->field($model,'category_id')->dropDownList($allCategory_id,['prompt'=>'请选择分类']);?>
    <?= $form->field($tagmodel,'name')->textInput(['maxlength' => true])?>
    <?= $form->field($model,'is_deleted')->dropDownList($status,['prompt'=>'请选择状态']);?>
    <div class="form-group">
        <?= Html::submitButton('保存', ['class' => 'btn btn-success']) ?>
    </div>
    <?php ActiveForm::end();?>
</div>
