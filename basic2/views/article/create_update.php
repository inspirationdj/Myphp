<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\form\ArticleCreateUpdateForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = '创建文章';

$allCategory_id=(new \yii\db\Query())
    ->select(['name','id'])
    ->from('category')
    ->indexBy('id')
    ->column();

$statusItems = [
        10=>'草稿',
        20=>'已发布',
        30=>'已删除',
];

$form = ActiveForm::begin();

if ($model->id) {
    echo $form->field($model, 'id')->textInput(['disabled' => true]);
}
echo $form->field($model, 'title');
echo $form->field($model, 'content')->textarea(['rows' => 10]);
echo $form->field($model, 'is_deleted')->dropDownList($statusItems, ['prompt' => '请选择状态']);
echo $form->field($model,'category_id')->dropDownList($allCategory_id,['prompt'=>'请选择分类']);
//echo  Html::a('添加分类', ['category/create'], ['class' => 'profile-link']);
echo $form->field($model, 'tags');

echo  Html::submitButton('保存', ['class' => 'btn btn-success']);

$form->end();

