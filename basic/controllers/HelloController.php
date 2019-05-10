<?php
namespace app\controllers;
use yii\web\Controller;
//use yii\web\Cookie;
use app\models\test;
use app\models\Customer;
use app\models\Order;
class HelloController extends Controller{
    public function actionIndex(){
/*        //跳转
        //$res=\YII::$app->response;
        //$this->redirect('http://www.baidu.com',302);

        //控制器之session 处理
        $session=\YII::$app->session;
        if(!$session->isActive){
            echo 'session is notActive';
        }
        $session ->open();
        $session ->set('user','张三');//保留一个session数据
        echo $session->get('user');//取出数据
        //$session->remove('user');

        //cookie处理
        $cookie=\YII::$app->response->cookies;
        $cookie_data=array('name'=>'user','value'=>'李四');
        $cookie->add(new Cookie($cookie_data));
        //$cookie->remove('id');
        //从请求中拿出cookie数据显示在网页上
        $cookie=\YII::$app->request->cookies;
        echo $cookie->getValue('user',20);//当user不存在默认输出20*/

        //查询数据
        //通过ID
        //$results= test::find()->where(['between','id',1,2])->all();
        //通过title字段
        //$results=test::find()->where(['like','title','title'])->all();
        //查询结果转化成数组
        //$results= test::find()->where(['between','id',1,2])->asArray()->all();
        //print_r($results);
        //批量查询
        //在数据库每次查询一条数据放在变量$tests中
//        foreach(test::find()->batch(1)as $tests){
//            print_r(count($tests));
//        }
        //删除数据（取出数据，变成对象，用对象中delete()方法删除）
//        $results=test::find()->where(['id'=>1])->all();
//        $results[0]->delete();

        //删除数据 快速方法
        //删除id>0的数据
        //test::deleteAll('id>:id',array(':id'=>0));

        //增加数据
//        $test =new test;
//        $test->id='3';
//        $test->title='title3';
//        $test->validate();
//        if($test->hasErrors()){
//            echo 'data is error';
//            die;
//        }
//        $test->save();

//        //修改数据
//        $test=test::find()->where(['id'=>3])->one();
//        $test->title='title4';
//        $test->save();

        //根据顾客查询订单信息
        //$customer= Customer::find()->where(['name'=>'张三'])->one();
        //$orders =$customer->hasMany(Order::className(),['customer_id'=>'id'])->asArray()->all();
        //$orders=$customer->orders;

        //根据订单查询顾客的信息
//        $order=Order::find()->where(['id'=>1])->one();
//        $orders= $order->customer;
//        unset($customer->orders);
//        print_r($orders);

        //关联查询的多次查询
//        $customers=Customer::find()->with('orders')->all();
//        foreach ($customers as $customer){
//            $orders= $customer->orders;
//        }

         //获取缓存组件
        //$cache=\YII::$app->cache;
            //有效期设置
//        $cache->set('key','hello world',15);
//        echo $cache->get('key');
        //文件依赖
//        $dependency= new \yii\caching\FileDependency(['fileName'=>'hw.txt']);
//        var_dump($cache->get('file_key'));

        //return $this->renderPartial('index');

        $request=\Yii::$app->request;
        $user=[
            'username'=>'DJ',
            'age'=>'26',
        ];
        $article=[
            'title'=>'DJ标题',
        ];
        return $this->render('index',compact('user','article'));



    }
}
