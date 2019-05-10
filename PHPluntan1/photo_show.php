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
define('SCRIPT','photo_show');

//全局
global $_system,$_id;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//删除相片
if($_GET['action']=='delete' && isset($_GET['id'])){
    $sql="select tg_sid,tg_id,tg_url,tg_username FROM tg_photo WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $e=mysqli_query($link,$sql);
    $resu=mysqli_fetch_array($e,MYSQLI_ASSOC);
    IF(!!$resu){
        $_html=array();
        $_html['url']=$resu['tg_url'];
        $_html['id']=$resu['tg_id'];
        $_html['sid']=$resu['tg_sid'];
        //首先删除图片数据库信息
        $s="DELETE FROM tg_photo WHERE tg_id='{$_html['id']}'";
        mysqli_query($link,$s);
        if(mysqli_affected_rows($link)==1){
            //删除图片物理地址
            if(file_exists($_html['url'])){
                unlink($_html['url']);
            }else{
                _alert_back('磁盘里不存在此图');
            }
            _location('删除成功','photo_show.php?id='.$_html['sid']);
        }else{
            _alert_back('删除图片失败');
        }

    }else{
        _alert_back('不存在此图片');
    }
}
//取值
if(isset($_GET['id'])){
    $sql="select tg_type,tg_id,tg_name from tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $result=mysqli_query($link,$sql);
    if(!!$_rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $_dirhtml=array();
        $_dirhtml['id']=$_rows['tg_id'];
        $_dirhtml['name']=$_rows['tg_name'];
        $_dirhtml['type']=$_rows['tg_type'];
        //对比加密相册的验证信息
        if($_POST['password']){
            $sql="select tg_id FROM tg_dir WHERE tg_password='".sha1($_POST['password'])."'                     LIMIT 1";
            $re=mysqli_query($link,$sql);
            if(!!$ro=mysqli_fetch_array($re,MYSQLI_ASSOC)){
                //生成COOKIE
                setcookie('photo'.$_dirhtml['id'],$_dirhtml['name']);
                //重定向
                _location(NULL,'photo_show.php?id='.$_dirhtml['id']);
            }else{
                echo '相册密码不正确';
            }

        }
    }else{
        _alert_back('不存在此相册');
    }
}else{
    _alert_back('非法操作');
}

//$_id='id='.$_html['id'].'&';

$_percent=0.5;
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

$_pagesize=$_system['photo'];
$_pagenum=($_page-1)*$_pagesize;
//首页要得到所有的数据总和
$sql="select tg_id from tg_photo WHERE tg_sid='{$_dirhtml['id']}'";
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
$query="select tg_readcount,tg_commendcount,tg_username,tg_id,tg_name,tg_url from tg_photo WHERE tg_sid='{$_dirhtml['id']}' ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);


?>

<!DOCTYPE html>
    <html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
require ROOT_PATH.'/includes/title.inc.php';
?>
    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
        <div id="photo">
        <h2><?php echo $_dirhtml['name'] ?></h2>
            <?php
            if(empty($_dirhtml['type'])||$_COOKIE['photo'.$_dirhtml['id']]==$_dirhtml['name']||isset($_SESSION['admin'])){


            $_html=array();
            while(@$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $_html['id']=$row['tg_id'];
            $_html['username']=$row['tg_username'];
            $_html['url']=$row['tg_url'];
            $_html['name']=$row['tg_name'];
            $_html['readcount']=$row['tg_readcount'];
            $_html['commendcount']=$row['tg_commendcount'];

            //$_html=$_html($_html);
            ?>
            <dl>
                <dt><a href="photo_detail.php?id=<?php echo $_html['id'] ?>"> <img src="thumb.php?filename=<?php echo $_html['url'] ?>&percent=<?php echo $_percent ?>"/></a></dt>
                <dd><a href="photo_detail.php?id=<?php echo $_html['id'] ?>"><?php echo $_html['name'] ?></a></dd>
                <dd>阅（<strong><?php echo $_html['readcount'] ?></strong>）评(<strong><?php echo $_html['commendcount'] ?></strong>) 上传者:<?php echo $_html['username']?></dd>
                <?php if($_html['username']==$_COOKIE['username']||isset($_SESSION['admin'])) {?>
                    <dd><a href="photo_show.php?action=delete&id=<?php echo $_html['id'] ?>">[删除]</a></dd>
                <?php } ?>
            </dl>
            <?php }
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

            <p><a href="photo_add_img.php?id=<?php echo $_dirhtml['id'] ?>">上传图片</a> </p>
            <?php }else{
                echo '<form method="post" action="photo_show.php?id='.$_dirhtml['id'].'">';
                echo '<p>请输入密码:<input type="password" name="password"/><input type="submit" value="确认" /> </p>';
                echo '</form>';

            }

            ?>
        </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
