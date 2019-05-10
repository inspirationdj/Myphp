<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/28
 * Time: 17:58
 */
namespace app\controllers;
use app\models\Post;
use app\models\PostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
class HomeController extends controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $searchModel= new PostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',[
            'searchModel'=>$searchModel,
            'dataProvider'=>$dataProvider,
        ]);
    }
    public function actionView($id)
    {
        return $this->render('view',['model'=>$this->findModel($id)]);
    }
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);
    }
    public function actionUpdate($id)
    {
        $model=$this->findModel($id);
        $model->tg_last_modify_date=time();
        if ($model->load(Yii::$app->request->post())&&$model->save())
        {
            return $this->redirect(['view','id'=>$model->tg_id]);
        }
        return $this->render('update',['model'=>$model,]);
    }
    public function actionCreate()
    {
        $model= new Post();
        if($model->load(Yii::$app->request->post())&&$model->save())
        {
            return $this->redirect(['view','id'=>$model->tg_id]);
        }
        return $this->render('create',['model'=>$model,]);
    }
    public function findModel($id)
    {
        if(($model=Post::findOne($id))!==null)
        {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}