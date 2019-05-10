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
define('SCRIPT','message');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
_alert_back('请先登录');
}
//写短信
if($_GET['action']=='write'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
    //引入验证文件
    include ROOT_PATH.'includes/register.func.php';
    $_clean=array();
    $_clean['touser']=$_POST['touser'];
    $_clean['fromuser']=$_COOKIE['username'];
    $_clean['content']=_check_content($_POST['content']);
    //写入表

      mysqli_query($link,"INSERT INTO tg_message(
                           tg_touser,
                           tg_fromuser,
                           tg_content,
                           tg_date
                        )
                  VALUES(
                          '{$_clean['touser']}',
                          '{$_clean['fromuser']}',
                          '{$_clean['content']}',
                          NOW()
        
                         )")or die('失败'.mysqli_error($link));
    $mysql=mysqli_affected_rows($link);


    //新增成功
   if($mysql>=0){
       //_session_destroy();
        _alert_close('短信发送成功');
    }else{
       //_session_destroy();
       _alert_back('短信发送失败');
    }
    exit();
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
    <h3>写短信</h3>
        <form method="post" action="?action=write">
         <input type="hidden" name="touser" value="<?php echo $_html['touser'] ?>"
            <dl>
        <dd><label><input type="text" readonly="readonly" value="TO:<?php echo $_html['touser'] ?>" class="text"/></label></dd>
        <dd><label><textarea name="content"></textarea></label></dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text.yzm" /> <img src="recode.php" id="code" /><input type="submit" class="submit" value="发送短信" /> </label></dd>

    </dl>
    </form>


</div>





    </body>
</html>