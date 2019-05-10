<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/12
 * Time: 16:53
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','photo_detail');

//全局
global $_system,$_id;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//评论
if($_GET['action']=='rephoto'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
    //接收数据
    $_clean=array();
    $_clean['sid']=$_POST['sid'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    $_clean['username']=$_COOKIE['username'];
    //写入数据库
    $sql="insert into tg_photo_commend(
                                      tg_username,
                                      tg_content,
                                      tg_title,
                                      tg_sid,
                                      tg_date                                     
                                      )
                              VALUES (
                                      '{$_clean['username']}',
                                      '{$_clean['content']}',
                                      '{$_clean['title']}',
                                      '{$_clean['sid']}',
                                      NOW()
                                      )";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)==1){
        $sql="update tg_photo_commend SET tg_commendcount=tg_commendcount+1 WHERE tg_id='{$_clean['sid']}'";
        mysqli_query($link,$sql);
        _location('评论成功','photo_detail.php?id='.$_clean['sid']);

    }else{
        _alert_back('非法登录');
    }

}
//取值
if(isset($_GET['id'])){


    $sql="select tg_content,tg_date,tg_readcount,tg_commendcount,tg_username,tg_id,tg_name,tg_url from tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $result=mysqli_query($link,$sql);
    if(!!$_rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        //防止加密相册图片穿插访问
        //先取得图片的SID 也就是目录
        //然后再判断目录是否是加密的
        //如果是加密的 再判断是否有对应的COOKIE并且等于相应的值
        //管理员不受限制
        if(isset($_SESSION['admin'])) {
            $sql = "select tg_name,tg_type,tg_id FROM tg_dir WHERE tg_id='{$_rows['sid']}'";
            $res = mysqli_query($link, $sql);
            if (!!$_dirs = mysqli_fetch_array($res,MYSQLI_ASSOC)) {
                if (!empty($_dirs['tg_type']) && $_COOKIE['photo' . $_dirs['tg_id']] != $_dirs['tg_name']) {
                    _alert_back('非法操作');
                }
            } else {
                _alert_back('相册目录表错误');
            }
        }
        //累计阅读量
        $sql="update tg_photo SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'";
        mysqli_query($link,$sql);
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['name']=$_rows['tg_name'];
        $_html['url']=$_rows['tg_url'];
        $_html['username']=$_rows['tg_username'];
        $_html['readcount']=$_rows['tg_readcount'];
        $_html['commendcount']=$_rows['tg_commendcount'];
        $_html['date']=$_rows['tg_date'];
        $_html['content']=$_rows['tg_content'];
    }else{
        _alert_back('不存在此图片');
    }
}else{
    _alert_back('非法操作');
}

//$_id='id='.$_html['id'].'&';
?>

<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
require ROOT_PATH.'/includes/title.inc.php';
?>
        <script type="text/javascript" src="js/code.js"></script>
        <script type="text/javascript" src="js/article.js"></script>
    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
        <div id="photo">
        <h2>图片详情</h2>
            <dl class="detail">
                <dd class="name"><?php echo $_html['name'] ?></dd>
                <dt><img src="<?php echo $_html['url'] ?>"/> </dt>
                <dd>浏览量（<strong><?php echo $_html['readcount'] ?></strong>）评论量（<strong><?php echo $_html['commendcount'] ?></strong>）上传者：<?php echo $_html['username'] ?>发表于 | <?php echo $_html['date'] ?></dd>
                <dd>简介:<?php echo $_html['content'] ?></dd>

            </dl>
        </div>

    <?php if(isset($_COOKIE['username'])) {?>
        <p class="line"></p>
        <form method="post" action="?action=rephoto">
            <input type="hidden" name="sid" value="<?php echo $_html['id'] ?>"/>
            <dl class="rephoto">
                <dd>标  题：<label><input type="text" name="title" class="text" value="RE:<?php echo $_html['name'] ?>"/> </label>(*必填，2-40位)</dd>
                <dd id="q">贴  图：<a href="javascript:;"> Q图系列[1] </a><a href="javascript:;"> Q图系列[2] </a> <a href="javascript:;">Q图系列[3]</a></dd>
                <dd>
                    <?php include ROOT_PATH.'includes/ubb.inc.php' ?>
                    <textarea name="content"></textarea>
                </dd>
                <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> <input type="submit" class="submit" value="发表帖子" /></label></dd>
            </dl>
        </form>
    <?php } ?>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
