<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/26
 * Time: 11:31
 */
namespace app\controllers;
use yii\web\controller;
use Yii;
use app\models\PostSearch;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Post;
use yii\web\ForbiddenHttpException;

    class PostController extends controller
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
        {   if(!Yii::$app->user->can('deletePost'))
        {
            throw new ForbiddenHttpException('对不起您没有权限操作');
        }
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
        {   if(!Yii::$app->user->can('createPost'))
        {
            throw new ForbiddenHttpException('对不起您没有权限操作');
        }
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