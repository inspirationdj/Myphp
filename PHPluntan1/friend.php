<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/14
 * Time: 13:12
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','friend');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
_alert_back('请先登录');
}
//添加好友
if($_GET['action']=='add'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
    //引入验证文件
    include ROOT_PATH.'includes/register.func.php';
    $_clean=array();
    $_clean['touser']=$_POST['touser'];
    $_clean['fromuser']=$_COOKIE['username'];
    $_clean['content']=_check_content($_POST['content']);
    //不能添加自己
    if($_clean['touser']==$_clean['fromuser']){
        _alert_close('不能添加自己');
    }
    //$_clean=_mysql_string($_clean);
    //数据库验证好友是否已经添加
    $sql="select tg_id from tg_friend where (tg_touser='{$_clean['touser']}' and tg_fromuser='{$_clean['fromuser']}')
                                       or (tg_touser='{$_clean['fromuser']}' and tg_fromuser='{$_clean['touser']}')
                                       LIMIT 1";
    $row=mysqli_query($link,$sql);

    if(mysqli_fetch_array($row)){
        _alert_back('你们已经添加为好友');
        }else{
        //添加好友信息
        $sql="insert into tg_friend(
                                    tg_touser,
                                    tg_fromuser,
                                    tg_content,
                                    tg_date                                 
                                    ) values(
                                    '{$_clean['touser']}',
                                    '{$_clean['fromuser']}',
                                    '{$_clean['content']}',
                                    NOW()
                                    ) ";
        $result=mysqli_query($link,$sql);
        if(mysqli_affected_rows($link)==1){
       // _session_destroy();
        _alert_close('好友添加成功，请等待验证');
        }else{
            //_session_destroy();
            _alert_close('你们已是好友，或未验证好友');
        }

    }

}
//获取数据
if(isset($_GET['id'])){
    //获取数据
    $query="select tg_username from tg_user WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $result=mysqli_query($link,$query);
    $row=mysqli_fetch_array($result);
    if($row){
$_html=array();
$_html['touser']=$row['tg_username'];
}else{
_alert_close('不存在此用户');
}
}else{
_alert_close('非法操作');
}
?>
<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/code.js"></script>
    <script type="text/javascript" src="js/message.js"></script>
</head>

    <body>

<div id="message">
    <h3>加好友</h3>
        <form method="post" action="?action=add">
         <input type="hidden" name="touser" value="<?php echo $_html['touser'] ?>"
            <dl>
        <dd><label><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser'] ?>" class="text"/></label></dd>
        <dd><label><textarea name="content">我非常想和你加为好友！</textarea></label></dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text.yzm" /> <img src="recode.php" id="code" /><input type="submit" class="submit" value="添加好友" /> </label></dd>

    </dl>
    </form>


</div>





    </body>
</html>