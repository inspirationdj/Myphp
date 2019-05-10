<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/30
 * Time: 11:42
 */
//全局变量
global $_system;
if(!defined('IN_TG')){
exit ('非法调用');
}else {
    //短信提醒COUNT(tg_id)是取得字段的总和
    if(isset($_COOKIE['username'])) {
        $sql = "select count(tg_id) as count from tg_message WHERE tg_state=0 and tg_touser='{$_COOKIE['username']}'";
        $result = mysqli_query($link, $sql);
        $_message = mysqli_fetch_array($result);
        if (empty($_message['count'])) {
            $_message_html = '<strong class="noread"><a href="member_message.php">(0)</a></strong>';
        } else {
            $_message_html = '<a  class="read"><a href="member_message.php">(' . $_message['count'] . ')</a></strong>';
        }
    }
echo '<script type="text/javascript" src="../js/skin.js"></script>';
echo '

<div id="header">
    <h1><a href="dj.php">多用户留言系统</a></h1>
    <ul>
        <li><a href="dj.php">首页 </a> </li>    
        ';
    if(isset($_COOKIE['username'])){
        echo '<li><a href="member.php">'.$_COOKIE['username'].'·个人中心 </a>'.$_message_html.'</li>';
    }else{

         if($_system['register']==1) {
             echo '<li><a href="register.php"> 注册 </a></li>';
         }
        echo '<li><a href="login.php">登录 </a></li>';
    }
        echo '<li><a href="blog.php?page=1">博友 </a></li>';
        echo '<li><a href="photo.php?page=1">相册 </a></li>';
        echo '<li class="skin" onmouseover="inskin()" onmouseout="outskin()">
                <a href="javascript:;">风格 </a>
                    <dl id="skin">
                     <dd><a href="skin.php?id=1">1号皮肤</a></dd>
                     <dd><a href="skin.php?id=2">2号皮肤</a></dd>
                     <dd><a href="skin.php?id=3">3号皮肤</a></dd>
                    </dl>
              </li>';
        if(isset($_COOKIE['username'])&&isset($_SESSION['admin'])) {
            echo '<li><a href="manage.php">管理 </a></li>';
        }
    if(isset($_COOKIE['username'])){
        echo '<li><a href="logout.php">退出 </a></li>';
    }

        echo '</ul>';
        echo '</div>';
}
if(PHP_VERSION<'5.1.0'){
    exit('Version is to low');
}
