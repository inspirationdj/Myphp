<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/31
 * Time: 13:51
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//定义个常量，用来置顶本页的内容
define('SCRIPT','upimg');
//必须是会员
if(!$_COOKIE['username']){
    _alert_back('非法登录');
}
//执行上传图片功能
if($_GET['action']=='up') {
    //设置上传图片的类型
    $_files = array('image/jpeg','image/pjpeg','image/png','image/x-png','image/gif');
    //判断上传的类型是否是数组里的一种
    if (!in_array($_FILES['userfile']['type'], $_files)) {
        _alert_back('本站只允许jpg,gif,png图片');
    }

//判断文件错误类型
    if ($_FILES['userfile']['error'] > 0) {
        switch ($_FILES['userfile']['error']) {
            case 1:
                _alert_back('上传文件超过约定值1');
                break;
            case 2:
                _alert_back('上传文件超过约定值2');
                break;
            case 3:
                _alert_back('部分文件被上传');
                break;
            case 4:
                _alert_back('没有任何文件被上传');
                break;
        }
        exit;
    }
//判断配置文件的大小
    if ($_FILES['userfile']['size'] > 1000000) {
        _alert_back('上传的文件不得超过1M');
    }
    //获取文件的扩展名
    $_n=explode('.',$_FILES['userfile']['name']);
    $_name=$_POST['dir'].'/' . time().'.'.$_n[1];
//移动文件
    if (is_uploaded_file($_FILES['userfile']['tmp_name'])) {
        if (!@move_uploaded_file($_FILES['userfile']['tmp_name'],$_name)) {
            _alert_back('移动失败');
        } else {
           // _alert_back('上传成功');
            echo "<script>alert('上传成功');window.opener.document.getElementById('url').value='$_name';window.close();</script>";
            exit();
        }
    } else {
        _alert_back('上传的临时文件不存在');
    }
}
//接收dir
if(!isset($_GET['dir'])){
    _alert_back('dir不存在');
}

?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
    <script type="text/javascript" src="js/opener.js"></script>
</head>
<body>
<div id="upimg" style="padding:20px;">
    <form enctype="multipart/form-data" action="upimg.php?action=up" method="post">
        <input type="hidden" name="MAX_FILE_SIZE" value="1000000"/>
        <input type="hidden" name="dir" value="<?php echo $_GET['dir'] ?>"/>
        选择图片：<input type="file" name="userfile"/>
        <input type="submit"  value="上传"/>
    </form>
</div>
</body>
</html>
