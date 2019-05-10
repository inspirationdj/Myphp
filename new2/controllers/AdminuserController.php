<?php
namespace app\controllers;

use app\models\LoginForm;
use yii\web\Controller;
use Yii;
use app\models\form\RegisterForm;
use yii\helpers\Url;

class AdminuserController extends  Controller
{
    public function actionRegister()
    {
        //$url = Url::to(['adminuser/login']);
        $model = new RegisterForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->register()) {
                return $this->redirect('http://localhost/new2/web/index.php?r=adminuser/login');
            }
        }
        return $this->render('register', [
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }
}