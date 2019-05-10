<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 11:24
 */
use yii\helpers\Html;
use app\models\Login;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
$model= Login::findOne($id);
$this->title='权限设置 '.$model->username;
$this->params['breadcrumbs'][]=['label'=>'管理员','url'=>['index']];
$this->params['breadcrumbs'][]=['label'=>$model->username,'url'=>['view','id'=>$id]];
$this->params['breadcrumbs'][]='权限设置';
?>
<div class="adminuser-update">
    <h1><?=Html::encode($this->title)?></h1>
    <div class="adminuser-privilege-form">
        <?php $form=ActiveForm::begin(); ?>
        <?=Html::checkboxList('newPri',$AuthAssignmentArray,$allPrivilegesArray);?>
        <div class="form-group">
            <?=Html::submitButton('设置')?>
        </div>
        <?php ActiveForm::end();?>
    </div>
</div>
