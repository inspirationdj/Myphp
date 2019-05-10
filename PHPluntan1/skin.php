<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/27
 * Time: 8:46
 */
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','skin');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
$_skin=$_SERVER['HTTP_REFERER'];
//必须从上一页点击过来
if(empty($_skinurl)||!isset($_GET['id'])){
    _alert_back('非法操作！');
}else {
//生成COOKIE用来保存皮肤
    setcookie('skin', $_GET['id']);
    header('Location:'.$_skinurl);
        }