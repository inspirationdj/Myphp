<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/14
 * Time: 17:56
 */
namespace app\controllers;
use app\models\SignupForm;
use yii\web\controller;
use Yii;
use yii\web\Response;
use yii\widgets\ActiveForm;

class SignupController extends controller
{

    public function actionSign()
    {
        $model = new SignupForm();
        if ($model->load(\Yii::$app->request->post())) {
//            if(Yii::$app->request->isAjax)
//            {
//                Yii::$app->response->format=Response::FORMAT_JSON;
//                return ActiveForm::validate($model);
//            }
            if ($user = $model->signup()) {

                    return $this->redirect('http://localhost/basic/web/index.php?r=login/denglu');

            }


        }
        return $this->render('signup', ['model' => $model]);


    }
}
