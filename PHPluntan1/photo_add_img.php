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
define('SCRIPT','photo_add_img');
//全局
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
require dirname(__FILE__).'./includes/register.func.php';
//必须是会员
if(!$_COOKIE['username']){
    _alert_back('非法登录');
}
//保存图片信息入表
if($_GET['action']=='addimg'){
    //接收数据
    $_clean=array();
    $_clean['name']=_check_dir_name($_POST['name'],2,20);
    $_clean['url']=_check_photo_url($_POST['url']);
    $_clean['content']=$_POST['content'];
    $_clean['sid']=$_POST['sid'];
    print_r($_clean);
    //写入数据库
    $sql="insert into tg_photo (
                                tg_name,
                                tg_url,
                                tg_content,
                                tg_sid,
                                tg_date,
                                tg_username
                                )
                        values (
                                 '{$_clean['name']}',
                                 '{$_clean['url']}',
                                 '{$_clean['content']}',
                                 '{$_clean['sid']}',
                                 NOW(),
                                 '{$_COOKIE['username']}'
                                )";
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)==1){
        echo '成功';
        _location('图片添加成功','photo_show.php?id='.$_clean['sid']);
    }else{
        _alert_back('图片添加失败');
    }
}
//取值
if(isset($_GET['id'])){
    $sql="select tg_id,tg_dir from tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $result=mysqli_query($link,$sql);
    if(!!$_rows=mysqli_fetch_array($result,MYSQLI_ASSOC)){
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['dir']=$_rows['tg_dir'];

    }else{
        _alert_back('不存在此相册');
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
        <script type="text/javascript" src="js/photo_add_img.js"></script>
    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
        <div id="photo">
        <h2>上传图片</h2>
            <form method="post" action="?action=addimg">
                <input type="hidden" name="sid" value="<?php echo $_html['id'] ?>"/>
            <dl>
                <dd>图片名称：<input type="text" name="name" class="text"/></dd>
                <dd><label>图片地址：<input type="text" name="url" id="url" readonly="readonly" class="text"/><a href="javascript:;" title="<?php echo $_html['dir'] ?>" id="up">上传</a></label></dd>
                <dd><label>图片简介：<textarea name="content"></textarea></label></dd>
                <dd><input type="submit" class="submit" value="添加图片"/> </dd>
            </dl>
            </form>
        </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
