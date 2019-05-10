<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/12
 * Time: 16:25
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','logout');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
_unsetcookies();