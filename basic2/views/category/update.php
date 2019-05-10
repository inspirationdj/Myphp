<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/22
 * Time: 9:27
 */
use yii\helpers\Html;
$this->title='更新标签: '.$model->name;
$this->params['breadcrumbs'][]=['label'=>'标签','url'=>['index']];
$this->params['breadcrumbs'][]='修改';
?>
<div class="category-update">
    <h1><?=Html::encode($this->title);?></h1>
<?= $this->render('_form', [
    'model' => $model,

]) ?>
</div>
