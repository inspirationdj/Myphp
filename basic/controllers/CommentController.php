<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/29
 * Time: 15:07
 */
namespace app\controllers;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\CommentSearch;

class CommentController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs'=>[
                'calss'=>VerbFilter::className(),
                'actions'=>[
                    'delete'=>['POST'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel=new CommentSearch();
        $dataProvider=$searchModel->search(\Yii::$app->request->queryParams);

    }
}