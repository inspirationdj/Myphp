<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/12
 * Time: 9:47
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','login');
//全局变量
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//登录状态
_login_state();
//开始处理登录状态
if($_GET['action']=='login'){
    if($_system['code']==1) {
        //防止恶意注册，跨站攻击
        _check_code($_POST['code'], $_SESSION['code']);
    }
    //引入验证文件
    include ROOT_PATH.'includes/login.func.php';
    //接受数据
    $_clean=array();
    $_clean['username']=_check_username($_POST['username'],2,20);
    $_clean['password']=_check_password($_POST['password'],6);
    $_clean['time']=_check_time($_POST['time']);
   // print_r($_clean);
    //到数据库去验证
    $query="select tg_username,tg_uniqid,tg_level from tg_user WHERE tg_username='{$_clean['username']}' and tg_password='{$_clean['password']}'";
    $result=mysqli_query($link,$query);
    $row=mysqli_fetch_array($result);

    if(mysqli_num_rows($result)==1) {
        //登录成功后，记录登录信息
        $query="UPDATE tg_user SET tg_last_time=NOW(),tg_last_ip='{$_SERVER["REMOTE_ADDR"]}',tg_login_count=tg_login_count+1 WHERE tg_username='{$row['tg_username']}'";
        $result=mysqli_query($link,$query);
        _location(null,'member.php');
//        echo $row['tg_username'];
//        echo $row['tg_uniqid'];
        //_session_destroy();
        _setcookies($row['tg_username'],$row['tg_uniqid'],$_clean['time']);
        if($row['tg_level']==1){
            $_SESSION['admin']=$row['tg_username'];
        }
    }else{
        //_session_destroy();

        _location('用户名密码不正确','login.php');
    }
//    if(mysql_affected_rows($sql)){
//        exit('用户名密码不正确');
//    }else{
//        exit('发现数据');
//    }

}

?>
<!DOCTYPE html>
    <html>
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>


    <link rel="shortcut icon" href="doc.jpg"/>
    <link rel="stylesheet" type="text/css" href="style/1/basic.css"/>
    <link rel="stylesheet" type="text/css" href="style/1/register.css"/>
        <?php
        require ROOT_PATH.'/includes/title.inc.php';
        ?>

        <script type="text/javascript" src="js/login.js"></script>
        <script type="text/javascript" src="js/code.js"></script>

</head>
<body>
<?php

require ROOT_PATH.'includes/header.inc.php';
?>
<div id="login">
    <h2>登录</h2>

    <form method="post" name='login' action="login.php?action=login">

        <dl>
            <dt>  </dt>
            <dd>用户名：  <label><input type="text" name="username" class="text"/> </label></dd>
            <dd>    密     码      ：<label><input type="password" name="password" class="text"/></label> </dd>
            <dd>保    留：<label><input type="radio" name="time" value="0" checked="checked"/> 不保留:    <input type="radio" name="time" value="1" /> 一天: <input type="radio" name="time" value="2"/> 一周:  <input type="radio" name="time" value="3"/></label>一月</dd>
            <?php if($_system['code']==1){ ?>
            <dd>验 证 码<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> </label></dd>
            <?php } ?>
            <dd><input type="submit" value="登录" class="button"/><input type="button" value="注册" id="location" class="button"/> </dd>
        </dl>
    </form>

</div>



<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
