<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/25
 * Time: 10:55
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//定义个常量，用来置顶本页的内容
define('SCRIPT','thumb');
//缩率图
if(isset($_GET['filename'])&&isset($_GET['percent'])) {
    _thumb($_GET['filename'], $_GET['percent']);
}



