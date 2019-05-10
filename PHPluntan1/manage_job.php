<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/14
 * Time: 17:14
 */
session_start();

//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','manage_job');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//必须是管理员才能登陆
_manage_login();
//添加管理员
if($_GET['action']=='add'){
    $_clean=array();
    $_clean['username']=$_POST['manage'];
    //添加
    $sql="update tg_user SET tg_level=1 WHERE tg_username='{$_clean['username']}'";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)==1){
        _location('添加成功',SCRIPT.'.php');
    }else{
        _alert_back('管理员添加失败');

    }
}
//辞职
if($_GET['action']=='job'&&isset($_GET['id'])){
    $sql="update tg_user SET tg_level=0 WHERE tg_username='{$_COOKIE['username']}'AND tg_id='{$_GET['id']}'";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)==1){
        _location('辞职成功','dj.php');
    }else{
        _alert_back('辞职失败');
    }
}
//分页模块
if(isset($_GET['page'])){
    $_page=$_GET['page'];
    if(empty($_page)||$_page<0||!is_numeric($_page)){
        $_page=1;
    }else{
        $_page=intval($_page);
    }
}else{
    $_page=1;
}

$_pagesize=10;
$_pagenum=($_page-1)*$_pagesize;
//首页要得到所有的数据总和
$sql="select tg_face from tg_user";
$result=mysqli_query($link,$sql);
$_num=$res=mysqli_num_rows($result);

//容错处理 数据库请0
if($_num==0){
    $_pageabsolute=1;
}else{
    $_pageabsolute=ceil($_num/$_pagesize);
}
//num>总页码
if($_page>$_pageabsolute){
    $_page=$_pageabsolute;
}

//读取数据
$query="select tg_id,tg_username,tg_reg_time from tg_user WHERE tg_level=1 ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);

?>
<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>

<script type="text/javascript" src="js/member_message.js"></script>
</head>
<body>
<?php
require 'includes/header.inc.php';
?>

     <?php require ROOT_PATH.'includes/manage.inc.php'?>
     <div id="member_main">
         <h2>会员列表中心</h2>
     <table cellspacing="1">
         <tr><th>ID号</th><th>会员名</th><th>注册时间</th><th>操作</th></tr>
         <?php
         $_html=array();
         while(@$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
         $_html['id']=$row['tg_id'];
         $_html['username']=$row['tg_username'];
         $_html['reg_time']=$row['tg_reg_time'];
        if($_COOKIE['username']==$_html['username']){
            $_html['job_html']='<a href="manage_job.php?action=job&id='.$_html['id'].'">辞职</a>';
        }else{
            $_html['job_html']='无权操作';
        }
         ?>
         <tr><td><?php echo $_html['id'] ?></td><td ><?php echo $_html['username'] ?></td><td><?php echo $_html['reg_time'] ?></td><td><?php echo $_html['job_html'] ?></td></tr>
         <?php } ?>
     </table>
             <form method="post" action="?action=add">
                 <input type="text" name="manage" class="text"/> <input type="submit" value="添加管理员" />
             </form>
         </form>
         <?php
         mysqli_free_result($result);
         ?>
         <div id="page_num">
             <ul>
                 <?php
                 for($i=0;$i<$_pageabsolute;$i++){
                     echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
                 }
                 ?>
             </ul>
         </div>
  </div>


<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
