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
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//定义个常量，用来置顶本页的内容
define('SCRIPT','article_modify');
//登录后才可以发帖
if(!isset($_COOKIE['username'])){
    _location('发帖前，必须登录','login.php');
}
    //修改
    if($_GET['action']=='modify'){
        //防止恶意注册，跨站攻击
        _check_code($_POST['code'],$_SESSION['code']);
        include ROOT_PATH.'includes/register.func.php';
        //开始修改

        //接收帖子内容
        $_clean=array();
        $_clean['id']=$_POST['id'];
        $_clean['type']=$_POST['type'];
        $_clean['title']=_check_post_title($_POST['title'],2,40);
        $_clean['content']=_check_post_content($_POST['content'],10);
        //执行SQL
        $sql="update tg_article SET
                                    tg_last_modify_date=NOW(),      
                                    tg_title='{$_clean['title']}',
                                    tg_type='{$_clean['type']}',
                                    tg_content='{$_clean['content']}'                            
                                    where tg_id='{$_clean['id']}'";

        mysqli_query($link,$sql);

        if(mysqli_affected_rows($link)==1){
            //_session_destroy();
            _location('帖子修改成功','article.php?id='.$_clean['id']);
       }else{
            //_session_destroy();
            _alert_back('帖子修改失败');
        }
    }
    //读取数据
        if(isset($_GET['id'])){
    $sql="select tg_username,tg_type,tg_content,tg_title from tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'";
    $result=mysqli_query($link,$sql);
    $_rows=mysqli_fetch_array($result);
        if($_rows){
        $_html=array();
        $_html['id']=$_GET['id'];
        $_html['username']=$_rows['tg_username'];
        $_html['title']=$_rows['tg_title'];
        $_html['content']=$_rows['tg_content'];
        $_html['type']=$_rows['tg_type'];
        if($_html['username']!=$_COOKIE['username']){
            _alert_back('你没有权限修改');
        }


    }else{
        _alert_back('不存在此帖');
    }
}else{
    _alert_back('非法操作');
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
    <h2>修改帖子</h2>
        <form method="post" name='post' action="?action=modify">
            <input type="hidden" value="<?php echo $_html['id'] ?>" name="id"/>
        <dl>
        <dt>请认真修改以下内容</dt>
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
            <dd>标  题：<label><input type="text" name="title" value="<?php echo$_html['title']?>" class="text"/> </label>(*必填，2-40位)</dd>
            <dd id="q">贴  图：<a href="javascript:;"> Q图系列[1] </a><a href="javascript:;"> Q图系列[2] </a> <a href="javascript:;">Q图系列[3]</a></dd>
            <dd>
            <?php include ROOT_PATH.'includes/ubb.inc.php'   ?>
                <textarea name="content"><?php echo $_html['content'] ?></textarea>
            </dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> <input type="submit" class="submit" value="修改帖子" /></label></dd>

        </dl>
        </form>
</div>
    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>
