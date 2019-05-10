<?php
/**
 * @var $this \yii\web\View
 * @var $model \app\models\form\ArticleCreateUpdateForm
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\bootstrap\Modal;
use yii\helpers\Url;

$this->title = '创建文章';

$statusData = [
    10 => '已发布',
    20 => '已删除',
];

$allCategory = (new \yii\db\Query())
    ->select('name')
    ->from('category')
    ->indexBy('id')
    ->column();

$form = ActiveForm::begin();
if ($model->id) {
    echo $form->field($model, 'id')->textInput(['disabled' => true]);
}

echo $form->field($model, 'title')->textInput();
echo $form->field($model,'content')->widget('vendor\ueditor\Ueditor', [
    'options'=>[
        'initialFrameWidth' => '100%',
        'initialFrameHeight' => '400',
        ]
    ]);
echo $form->field($model, 'status')->dropDownList($statusData, ['prompt' => '请选择状态']);
echo $form->field($model, 'category_id')->dropDownList($allCategory, ['prompt' => '请选择分类','id' => 'drop1']);
   // echo Html::a('添加标签', ['category/create'], ['class' => 'btn btn-success']);
echo Html::a('添加分类','category/article-create',[
    'id' => 'create',
    'data-toggle' => 'modal',
    'data-target' => '#create-modal',
    'class' => 'btn btn-success',
]);

echo $form->field($model, 'tags')->textInput();
echo Html::submitButton('保存', ['class' => 'btn btn-success']);
$form->end();

Modal::begin([
    'id' => 'create-modal',
    'header' => '<h4 class="modal-title">创建</h4>',
    'footer' => '<a href="#" class="btn btn-danger" data-dismiss="modal">Close</a>',
]);

$requestUrl = Url::toRoute('category/article-create');
$js = <<<JS
    $(document).on('click', '#create', function () {
        $.get('{$requestUrl}', {},
            function (data) {
                $('.modal-body').html(data);
            }  
        );
    });
JS;
$this->registerJs($js);
Modal::end();