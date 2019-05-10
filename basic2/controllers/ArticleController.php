<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/4/3
 * Time: 15:32
 */

namespace app\controllers;

use app\models\form\ArticleCreateUpdateForm;
use Codeception\Lib\Driver\PostgreSql;
use yii\web\controller;
use Yii;
use app\models\Article;
use app\models\ArticleSearch;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use app\models\Tag;
use yii\base\Model;
use app\models\TagArticleLink;

class ArticleController extends controller
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
        $searchModel = new ArticleSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);

    }

    public function actionCreate()
    {
        $model = new ArticleCreateUpdateForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $result = $model->create();
            if ($result !== false) {
                return $this->redirect(['view', 'id' => $result->id]);
            }
        }
        return $this->render('create_update', [
            'model' => $model
        ]);


        /*$tagmodel = new Tag();//用于获取POST
        $model = new Article();
        if ($model->load(Yii::$app->request->post()) && $tagmodel->load(Yii::$app->request->post()) && Model::validateMultiple([$model, $tagmodel])) {
            //false参数避免进行内部二次验证
            $tagstr = explode(' ', Yii::$app->request->post('Tag')['name']);
            $tag = Tag::findAll(['name' => $tagstr]);
            $arrs = [];
            $val = [];
            $arr = [];//存放输入标签和数据表标签想匹配的数组

            foreach ($tag as $v) {
                $arrs[] = $v['name'];
                $val[] = $v['id'];

            }
            foreach ($arrs as $v) {
                if (in_array($v, $tagstr)) {
                    $arr[] = $v;
                }

            }
            $res = array_combine($val, $arrs);
            $aer = array_diff($tagstr, $arr);

            $model->save(false);
            //存在于标签数据库的标签
            foreach ($res as $k => $v) {
                $link = new TagArticleLink();
                $link->article_id = $model->id;
                $link->tag_id = $k;
                $link->save();
            }
            //不存在于标签数据库的标签
            foreach ($aer as $value) {
                $tagsmodel = new Tag();
                $tagsmodel->name = $value;
                $tagsmodel->save(false);
                $link = new TagArticleLink();
                $link->article_id = $model->id;
                $link->tag_id = $tagsmodel->id;
                $link->save();
            }

            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
            'tagmodel' => $tagmodel,
        ]);*/

    }

    public function actionUpdate($id)
    {
        $model = new ArticleCreateUpdateForm([
            'id' => $id,
        ]);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
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
        $a = $this->findModel($id);
        $a->is_deleted = '30';
        $a->save();
        return $this->redirect(['index']);
    }

    public function findModel($id)
    {
        if (($model = Article::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('请求页面不存在');

    }


}