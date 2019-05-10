<?php
namespace app\controllers;

use app\models\Category;
use app\models\CategorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use Yii;
use yii\helpers\url;
use  yii\web\Response;
use yii\widgets\ActiveForm;

class CategoryController extends Controller
{
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        Url::remember();
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionDelete($id)
    {
        $allArticle = (new \yii\db\Query())
            ->select('category_id')
            ->from('article')
            ->where(['category_id' => $id])
            ->one();
        if($allArticle ==null) {
            $cate = $this->findModel($id);
            $cate->delete();
            return $this->redirect(['index']);
        }else {
            throw new NotFoundHttpException('次分类已有文章');
        }
    }

    public function actionCreate()
{
    $model = new Category();
    if($model->load(Yii::$app->request->post())&&$model->save()) {
        $url = Url::previous();
        if($url) {
            return $this->redirect($url);
        }
        return false;
    }
    return $this->render('create',[
        'model' => $model,
    ]);
}

    public function actionView($id)
    {
        return $this->render('view',[
            'model' => $this->findModel($id),
        ]);
    }

    public function actionUpdate($id)
    {
        $allArticle = (new \yii\db\Query())
            ->select('category_id')
            ->from('article')
            ->where(['category_id' => $id])
            ->one();
        if($allArticle ==null) {
            $model = $this->findModel($id);
            if($model->load(Yii::$app->request->post())&&$model->save()) {
                return $this->redirect(['view',
                    'id' => $model->id,
                ]);
            }else {
                return $this->render('update', [
                    'model' => $model,
                ]);
            }
        }else {
            throw new NotFoundHttpException('此分类已有文章');
        }
    }

    public function actionArticleCreate()
    {
        $model = new Category();
        if($model->load(Yii::$app->request->post())&&$model->save()) {
            $url = Url::previous();
            if($url) {
                return $this->render($url);
            }
            return false;
        }
        return $this->renderAjax('article-create',[
            'model' => $model,
        ]);
    }

    public function findModel($id)
    {
        if(($model = Category::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('此标签页不存在');
    }

    public function actionValidate()
    {
        $model = new Category();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
        }
        return false;
    }

    public function actionSave()
    {   sleep(5);
        $model = new Category();
        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) {
                return json_encode(['status' => 1,'value' => $model->id,'name' => $model->name]);
            }
            return json_encode(['status' => 0]);
        }
        return json_encode(['status' => 2]);
    }
}
