<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/5
 * Time: 10:37
 */
namespace app\controllers;
use app\models\LoginForm;
use yii\web\Controller;
use app\models\Login;
use Yii;


class LoginController extends Controller{
    public function  actionDenglu()
    {

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(\Yii::$app->request->post())&&$model->login()) {
            return $this->goBack();

            }else {
            $model->password = '';
            return $this->render('blog', ['model' => $model,]);

        }


    }

//&&$model->$model(Yii::$app->params['adminEmail'])



}
