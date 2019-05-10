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
define('SCRIPT','member_flower');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
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
<?php require 'includes/header.inc.php'; ?>
<body>


<?php

//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}
//批删除花朵
if(($_GET['action'])=='delete'&&isset($_POST['ids'])){
    $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
    //危险操作，为防止cookies伪造，还要对比一下唯一标识符 （未做）
    $sql="delete from tg_flower where tg_id IN({$_clean['ids']})";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)){
        _location('删除成功','member_flower.php');
    }else{
        _alert_back('删除失败');

    }
    exit();
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

$_pagesize=4;
$_pagenum=($_page-1)*$_pagesize;
//首页要得到所有的数据总和
$sql="select tg_content from tg_flower WHERE tg_touser='{$_COOKIE['username']}'";
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
//从数据库中提取数据
$query="select tg_id,tg_fromuser,tg_content,tg_date,tg_flower from tg_flower WHERE tg_touser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);
?>

     <?php require ROOT_PATH.'includes/member.inc.php'?>
     <div id="member_main">
         <h2>花朵管理中心</h2>
         <form method="post" action="?action=delete">
     <table cellspacing="1">
        <tr><th>送花人</th><th>花朵数目</th><th>感言</th><th>时间</th><th>操作</th></tr>
         <?php
         $_html=array();
         while(@$row=mysqli_fetch_array($result)){
             $_html['id']=$row['tg_id'];
             $_html['fromuser']=$row['tg_fromuser'];
             $_html['content']=$row['tg_content'];
             $_html['date']=$row['tg_date'];
             $_html['flower']=$row['tg_flower'];
             $_html['count']+=$_html['flower'];


         ?>
             <tr><td><?php echo $_html['fromuser'] ?></td><td><img src="iamge/x4.png" alt="花朵">x<?php echo $_html['flower'] ?>朵</td><td><?php echo _title($_html['content'],14) ?></td><td><?php echo $_html['date'] ?></td><td><input name="ids[]" value="<?php echo $_html['id'] ?>" type="checkbox"/></td></tr>
         <?php }
         mysqli_free_result($result);
         ?>
         <tr><td colspan="5">共<?php echo $_html['count'] ?>朵花</td></tr>
         <tr><td colspan="5">全选<label for="all"><input type="checkbox" name="chkall" id="all"/> </label><input type="submit" value="批删除"></td></tr>



     </table>
         </form>
  </div>
<div id="page_num">
    <ul>
        <?php
        for($i=0;$i<$_pageabsolute;$i++){
            echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
        }

        ?>

    </ul>
</div>

<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
