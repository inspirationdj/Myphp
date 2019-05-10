<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/31
 * Time: 10:07
 */
session_start();
ini_set("error_reporting","E_ALL & ~E_NOTICE");
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//全局变量
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//定义个常量，用来置顶本页的内容
define('SCRIPT','post');
//登录后才可以发帖
if($_GET['action']=='post'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
    include ROOT_PATH.'includes/register.func.php';
    //验证是否在规定时间外发帖
    _timed(time(),$_COOKIE['post_time'],$_system['post']);
    //接收帖子内容
    $_clean=array();
    $_clean['username']=$_COOKIE['username'];
    $_clean['type']=$_POST['type'];
    $_clean['title']=_check_post_title($_POST['title'],2,40);
    $_clean['content']=_check_post_content($_POST['content'],10);

    //写入数据库
    $sql="insert into tg_article(
                                tg_username,
                                tg_title,
                                tg_type,
                                tg_content,
                                tg_date
                                )
                          VALUES(
                                  '{$_clean['username']}',
                                  '{$_clean['title']}',
                                  '{$_clean['type']}',
                                  '{$_clean['content']}',
                                  NOW()
                                 ) ";
        mysqli_query($link,$sql);
        if(mysqli_affected_rows($link)==1){
            $_clean['id']=mysqli_insert_id($link);
            setcookie('post_time',time());
            //_session_destroy();
            _location('帖子发表成功','article.php?id='.$_clean['id']);
        }else{
            //_session_destroy();
            _alert_back('帖子发表失败');
        }
}
if(!isset($_COOKIE['username'])){
    _location('发帖前需要先登录','login.php');
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
        <script type="text/javascript" src="js/post.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>
<div id="post">
    <h2>发表帖子</h2>
        <form method="post" name='post' action="?action=post">
        <dl>
        <dt>请认真填写以下内容</dt>
            <dd>
                类    型：
                <?php
                foreach(range(1,7) as $_num){
                    if($_num==1){
                        echo '<input type="radio" name="type" value="'.$_num.'"  checked="checked"> ';
                    }else{
                        echo '<input type="radio" name="type" value="'.$_num.'"  > ';
                    }

                    echo '<img src="iamge/icon'.$_num.'.png" alt="类型"/> ';
                }
                ?>
            </dd>
            <dd>标  题：<label><input type="text" name="title" class="text"/> </label>(*必填，2-40位)</dd>
            <dd id="q">贴  图：<a href="javascript:;"> Q图系列[1] </a><a href="javascript:;"> Q图系列[2] </a> <a href="javascript:;">Q图系列[3]</a></dd>
            <dd>
            <?php include ROOT_PATH.'includes/ubb.inc.php'   ?>
                <textarea name="content"></textarea>
            </dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> <input type="submit" class="submit" value="发表帖子" /></label></dd>

        </dl>
        </form>
</div>
    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>
