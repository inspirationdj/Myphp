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
define('SCRIPT','member_message');
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
//批删除短信
if(($_GET['action'])=='delete'&&isset($_POST['ids'])){
    $_clean=array();
    $_clean['ids']=_mysql_string(implode(',',$_POST['ids']));
    //危险操作，为防止cookies伪造，还要对比一下唯一标识符 （未做）
    $sql="delete from tg_message where tg_id IN({$_clean['ids']})";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)){
        _location('删除成功','member_message.php');
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
$sql="select tg_content from tg_message WHERE tg_touser='{$_COOKIE['username']}'";
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
$query="select tg_id,tg_fromuser,tg_content,tg_date,tg_state from tg_message WHERE tg_touser='{$_COOKIE['username']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);
?>

     <?php require ROOT_PATH.'includes/member.inc.php'?>
     <div id="member_main">
         <h2>短信管理中心</h2>
         <form method="post" action="?action=delete">
     <table cellspacing="1">
        <tr><th>发信人</th><th>短信内容</th><th>时间</th><th>状态</th><th>操作</th></tr>
         <?php
            $_html=array();
         while(@$row=mysqli_fetch_array($result)){
             $_html['id']=$row['tg_id'];
             if($row['tg_state']==0){
                 $_html['state']='<img src="iamge/noread.png" alt="未读" title="未读"/>';
                 $_html['content_html']='<strong>'._title($_html['content'],14).'</strong>';
             }else{
                 $_html['state']='<img src="iamge/read.png" alt="已读" title="已读"/>';
                 $_html['content_html']=_title($_html['content'],14);
             }

             $_html['fromuser']=$row['tg_fromuser'];
             $_html['content']=$row['tg_content'];
             $_html['date']=$row['tg_date'];

         ?>
             <tr><td><?php echo $_html['fromuser'] ?></td><td ><a href="member_message_detail.php?id=<?php echo $_html['id'] ?>" title="<?php echo $_html['content'] ?>"><?php echo $_html['content_html'] ?> <?php echo _title($_html['content'],10) ?></a></td><td><?php echo $_html['date'] ?></td><td><?php echo $_html['state'] ?></td><td><input name="ids[]" value="<?php echo $_html['id'] ?>" type="checkbox"/></td></tr>
         <?php }
         mysqli_free_result($result);
         ?>
         <tr><td colspan="4">全选<label for="all"><input type="checkbox" name="chkall" id="all"/> </label><input type="submit" value="批删除"></td></tr>


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
