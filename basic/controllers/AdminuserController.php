<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/3/20
 * Time: 14:46
 */
namespace app\controllers;
use app\models\AuthAssignment;
use app\models\AuthItem;
use app\models\ResetpwdForm;
use Yii;
use app\models\Login;
use app\models\AdminuserSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class AdminuserController extends Controller
{
    public function behaviors()
{
    return [
        'verbs'=>[
            'class'=>VerbFilter::className(),
            'actions' => [
                'delete'=>['POST'],
            ],
        ],
    ];
}

    public function actionIndex()
        {

//            $adminuser=Login::find()->where(['tg_level'=>1])->all();
//            foreach ($adminuser as $val)
//            {
//                $permissions=$val->permission;
//                print_r($permissions);
//            }
//
//                exit();
            $searchModel=new AdminuserSearch();
            $dataProvider=$searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index',
            ['searchModel'=>$searchModel,
             'dataProvider'=>$dataProvider,
                //'permissions'=>$val,

            ]);

    }
    public function actionView($id)
    {
        $model = Login::findOne($id);
        return $this->render('view',['model'=>$model,]);
    }

    public function actionCreate()
    {
        $model = new Login();
        if($model->load(Yii::$app->request->post())&&$model->save())
        {
            return $this->redirect(['view','id'=>$model->tg_id]);
        }
        return $this->render('create',['model'=>$model,]);
    }
    public function actionUpdate($id)
    {
        $model=$this->findModel($id);
        if($model->load(Yii::$app->request->post())&&$model->save())
        {
            return $this->redirect(['view','id'=>$model->tg_id]);
        }
        return $this->render('update',['model'=>$model,]);


    }

    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        return $this->redirect(['index']);

    }
    public function findModel($id)
    {
        if(($model=Login::findOne($id))!==null)
        {       //print_r($model);
                //exit();
            return $model;

        }
        throw new NotFoundHttpException('The requested page does not exist');
    }
    public function actionResetpwd($id)
    {
        $model=new ResetpwdForm();
        if($model->load(Yii::$app->request->post()))
        {
            if($model->resetPassword($id))
            {
                return $this->redirect(['index']);
            }
        }
        return $this->render('resetpwd',['model'=>$model]);
    }
    public function actionPrivilege($id)
    {
        //找出所有权限提供给checkboxlist
        $allPrivileges=AuthItem::find()->select(['name','description'])
            ->where(['type'=>1])
            ->orderBy('description')
            ->all();
        foreach ($allPrivileges as $pri)
        {
            $allPrivilegesArray[$pri->name]=$pri->description;
        }
        //当前用户权限
        $AuthAssignments=AuthAssignment::find()->select(['item_name'])
            ->where(['user_id'=>$id])
            ->orderBy('item_name')
            ->all();
        $AuthAssignmentsArray=array();
        foreach ($AuthAssignments as $AuthAssignment)
        {
            array_push($AuthAssignmentsArray,$AuthAssignment->item_name);
        }
        //从表单提交的数据来更新AuthAssignment表从而用户的角色发生变化
if(isset($_POST['newPri']))
{
    AuthAssignment::deleteAll('user_id=:id',[':id'=>$id]);
    $newPri=$_POST['newPri'];
    $arrlength = count($newPri);
    for ($x=0;$x<$arrlength;$x++)
    {
        $aPri=new AuthAssignment();
        $aPri->item_name=$newPri[$x];
        $aPri->user_id=$id;
        $aPri->created_at=time();
        $aPri->save();
    }
    return $this->redirect(['index']);
}
//渲染checkBoxList表单
return $this->render('privilege',['id'=>$id,
    'AuthAssignmentArray'=>$AuthAssignmentsArray,
    'allPrivilegesArray'=>$allPrivilegesArray]);
}
}