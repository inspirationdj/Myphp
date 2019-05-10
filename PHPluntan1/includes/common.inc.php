<?php
error_reporting( E_ALL&~E_NOTICE );
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/31
 * Time: 8:50
 */
//define('IN_TG',true);
//防止恶意调用
if(!defined('IN_TG')){
    exit('Access Defined!');
}
//设置字符集编码
header('Content-Type:text/html; charset=utf-8');

//转换硬路径常量
define('ROOT_PATH',substr(dirname(__FILE__),0,-8));

//创建一个自动转义状态的常量
define('GPC',get_magic_quotes_gpc());

//拒绝PHP低版本
if(PHP_VERSION<'4.1.0'){
    exit('Version is to low');
}

//引入核心函数库
require ROOT_PATH.'/includes/global.func.php';

//执行耗时
$_start_time=_runtime();
$_end_time=_runtime();
//echo $_end_time-$_start_time;

//连接数据库
//define('DB_HOST','localhost');
//define('DB_USER','ROOT');
//define('DB_PWD','123456');
//define('DB_NAME','testguest');
//创建数据库连接
$link =mysqli_connect('localhost','root','123456','testguest');
if(!$link){
    die('can not connect'.mysqli_error($link));
}else{
    echo "数据库连接成功";
}
//选择字符集
@mysqli_set_charset($mysqli,'utf8');


//做测试
//$query="select * from tg_user where tg_username='蜡笔小新'";
//if(mysqli_fetch_array($query,MYSQLI_ASSOC)) {
//    echo "有重复";
//}else {
//    echo "没有重复";
//}

//网站系统设置初始化
//读取系统表
$sql="select * from tg_system WHERE tg_id=1 LIMIT 1";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result);
if(!!$row) {
    $_system=array();
    $_system['webname'] = $row['tg_webname'];
    $_system['blog'] = $row['tg_blog'];
    $_system['article'] = $row['tg_article'];
    $_system['photo'] = $row['tg_photo'];
    $_system['skin'] = $row['tg_skin'];
    $_system['string'] = $row['tg_string'];
    $_system['post'] = $row['tg_post'];
    $_system['re'] = $row['tg_re'];
    $_system['code'] = $row['tg_code'];
    $_system['register'] = $row['tg_register'];
    //如果有skin的COOKIE 就替代系统数据库的皮肤
    if($_COOKIE['skin']){
        $_system['skin']=$_COOKIE['skin'];
    }
}else{
    exit('系统表异常，请检查');
}


