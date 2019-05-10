<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/8
 * Time: 9:06
 */
namespace app\controllers;
use app\models\CategorySearch;
use Yii;
use app\models\Category;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Article;


class CategoryController extends Controller{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST','GET'],
                ],
            ],
        ];
    }
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


    }
    public function actionCreate()
    {
        $model = new Category();
        if ($model->load(Yii::$app->request->post())&&$model->save()) {

            return $this->redirect(['index']);
        }
        return $this->render('create',['model'=>$model,]);

    }

    public function actionUpdate($id)
    {
        $category_id=(new \yii\db\Query())
        ->select('category_id')
        ->from('article')
        ->all();
        $ids=array_column($category_id,'category_id');
        if(!in_array($id,$ids)) {
            $model = $this->findModel($id);
            if (Yii::$app->request->post() && $model->save()) {

                //echo $model->errors;exit;
                return $this->redirect(['index']);
            } else {
                return $this->render('update', ['model' => $model]);
            }
        }else{
            throw new NotFoundHttpException('已有文章分类到此ID');
        }
    }
    public function actionDelete($id)
    {   //此处$category_id是一个数组
        $category_id=(new \yii\db\Query())
            ->select('category_id')
            ->from('article')
            ->all();
        $ids=array_column($category_id,'category_id');
        if(!in_array($id,$ids)) {
            $b = $this->findModel($id);
            $b->delete();
            return $this->redirect(['index']);
        }else {
            throw new NotFoundHttpException('已有文章分类到此ID');
              }
    }
    public function findModel($id)
    {
        if (($model=Category::findOne($id))!==null)
        {
            return $model;
        }
        throw new NotFoundHttpException('页面不存在');
    }
}