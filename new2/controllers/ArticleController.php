<?php

namespace app\controllers;

use yii\helpers\Url;
use yii\web\Controller;
use app\models\Article;
use yii\web\NotFoundHttpException;
use app\models\ArticleSearch;
use app\models\form\ArticleCreateUpdateForm;
use app\models\Category;
use vendor\ueditor;

class ArticleController extends Controller
{

    public function actions()
    {
        return [
            'ueditor' => [
                'class' => 'vendor/ueditor',
                'config' => [
                    //上传图片配置
                    'imageUrlPrefix' => "", /* 图片访问路径前缀 */
                    'imagePathFormat' => "/images/{yyyy}{mm}{dd}/{time}{rand:6}", /* 上传保存路径,可以自定义保存路径和文件名格式 */
                ]
            ]
        ];
    }
    public function actionIndex()
    {
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(\Yii::$app->request->queryParams);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = new ArticleCreateUpdateForm([
            'id' => $id
        ]);
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $result = $model->create();
            if ($result !== false) {
                return $this->redirect(['view', 'id' => $result->id]);
            }
        }
        return $this->render('create_update', [
            'model' => $model
        ]);
    }

    public function actionDelete($id)
    {
        $art = $this->findModel($id);
        $art->status = 20;
        $art->save();
        return $this->redirect(['index']);

    }

    public function actionCreate()
    {
        $model = new ArticleCreateUpdateForm();
        Url::remember();
        if ($model->load(\Yii::$app->request->post()) && $model->validate()) {
            $result = $model->create();
            if ($result !== false) {
//                echo $result->id;exit;
                return $this->redirect(['view', 'id' => $result->id]);
            }
        }
        return $this->render('create_update', [
            'model' => $model,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('页面不存在');
    }

}