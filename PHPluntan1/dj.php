<?php
error_reporting( E_ALL&~E_NOTICE );
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','dj');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//echo PHP_VERSION;
//读取XML文件
$_html=_get_xml('new.xml');
//读取帖子列表
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

$_pagesize=5;
$_pagenum=($_page-1)*$_pagesize;
//首页要得到所有的数据总和
$sql="select tg_id from tg_article WHERE tg_reid=0";
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
$query="select tg_title,tg_id,tg_readcount,tg_commendcount,tg_type from tg_article WHERE tg_reid=0 ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);
//最新图片，找到时间点最后上传的那张图片，并且是非私密的
$sql="select tg_id AS id,tg_name AS name,tg_url AS url FROM tg_photo WHERE tg_sid in(select tg_id from tg_dir WHERE tg_type=0) ORDER BY tg_date DESC LIMIT 1";
$r=mysqli_query($link,$sql);
$_photo=mysqli_fetch_array($r,MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
<!--    <link rel="shortcut icon" href="doc.jpg"/>-->
<!--    <link rel="stylesheet" type="text/css" href="style/1/basic.css"/>-->
<!--    <link rel="stylesheet" type="text/css" href="style/1/dj.css"/>-->
    <script type="text/javascript" src="js/blog.js"></script>
</head>
<body>
<?php

require 'includes/header.inc.php';

?>

<div id="list">
  <h2>帖子列表</h2>
    <a href="post.php" class="post">发表帖子</a>
    <ul class="article">
        <?php
            $_htmllist=array();
            while(@$row=mysqli_fetch_array($result)){
                $_htmllist['id']=$row['tg_id'];
                $_htmllist['type']=$row['tg_type'];
                $_htmllist['readcount']=$row['tg_readcount'];
                $_htmllist['commendcount']=$row['tg_commendcount'];
                $_htmllist['title']=$row['tg_title'];
            echo '<li class="icon1"><em>阅读数（<strong>'.$_htmllist['readcount'].'</strong>）评论数（<strong>'.$_htmllist['commendcount'].'</strong>）</em><a href="article.php?id='.$_htmllist['id'].'">'._title($_htmllist['title'],20).'</a></li>';
        }
        mysqli_free_result($result);
        ?>

    </ul>
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
<div id="user">
    <h2>新进会员</h2>
    <dl>
        <dd class="user"><?php echo $_html['username'] ?></dd>
        <dt><img src="<?php echo $_html['face'] ?>" </dt>
        <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['id'] ?>">发消息</a></dd>
        <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['id'] ?>">加好友</a></dd>
        <dd class="guest">写留言</dd>
        <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['id'] ?>">送花朵</a></dd>
        <dd class="url">网址：<a href="<?php echo $_html['url']?>"target="_blank"><?php echo $_html['url'] ?></a></dd>

    </dl>
</div>

<div id="pics">
    <h2>最新图片--<?php echo $_photo['name'] ?></h2>
    <a href="photo_detail.php?id=<?php echo $_photo['id'] ?>"> <img src="thumb.php?filename=<?php echo $_photo['url'] ?>&percent=0.3" alt="<?php echo $_photo['name'] ?>"/></a>
</div>
<?php
require 'includes/footer.inc.php';
?>


</body>
</html>

<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/29
 * Time: 16:48
 */
