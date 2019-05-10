<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

?>
<div class="category-form">
    <?php $form = ActiveForm::begin([
        'id' => 'article-create',
        'action' => Url::to(['category/save']),
        'enableAjaxValidation' => true,
        'validationUrl' => Url::to(['category/validate']),
    ]);
     ?>
    <?= $form->field($model, 'name')->textInput() ?>
    <div class="form-group">
        <?= Html::Button('新建',['class' => 'btn btn-primary','id' => 'sub']) ?>
    </div>
    <?php ActiveForm::end(); ?>
</div>
<?php
$url = Url::to(['category/save']);
$js = <<<JS
$('#sub').click(function () {
$.ajax({    
        url: '$url',
        type: "POST",
        dataType: "json",
        data: $('form').serialize(),
        success: function(Data) {
            if(Data.status === 1){
                alert('保存成功');
                let category = $("<option value="+Data.value+">"+Data.name+"</option>");
               $('select[id="drop1"] option:first').after(category);
                }
          else if(Data.status === 0)
                alert('保存失败');
          else if(Data.status === 2)
                alert('错误');
        },
        error: function(xhr) {
            alert(xhr.status);
        }
    });
                
    return false;

});
JS;
$this->registerJs($js);
?>

