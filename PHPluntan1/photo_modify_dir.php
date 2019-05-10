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
define('SCRIPT','photo_add_dir');
//全局
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
require dirname(__FILE__).'./includes/register.func.php';
//必须是管理员才能登陆
_manage_login();
//修改
if($_GET['action']=='modify'){
    //接受数据
    $_clean=array();
    $_clean['id']=$_POST['id'];
    $_clean['name']=_check_dir_name($_POST['name'],2,20);
    $_clean['type']=$_POST['type'];
    if($_clean['type']==1) {
        $_clean['password'] = _check_dir_password($_POST['password'],6);
    }
    $_clean['face']=$_POST['face'];
    $_clean['content']=$_POST['content'];
    //修改目录
    if($_clean['type']==0){
        $sql="update tg_dir SET tg_name='{$_clean['name']}',
                                tg_type='{$_clean['type']}',
                                tg_password=NULL,
                                tg_face='{$_clean['face']}',
                                tg_content='{$_clean['content']}'
                          where tg_id='{$_clean['id']}'
                          LIMIT  1 ";
        mysqli_query($link,$sql);
    }else{
        $sql="update tg_dir SET tg_name='{$_clean['name']}',
                                tg_type='{$_clean['type']}',
                                tg_password='{$_clean['password']}',
                                tg_face='{$_clean['face']}',
                                tg_content='{$_clean['content']}'
                          where tg_id='{$_clean['id']}'
                          LIMIT  1 ";
        mysqli_query($link,$sql);

    }
    if(mysqli_affected_rows($link)==1){
        _location('目录修改成功','photo.php');
    }else{
        _alert_back('目录修改失败');
    }

}
//读出数据
if(isset($_GET['id'])){
    $sql="select tg_id,tg_name,tg_type,tg_face,tg_content FROM tg_dir WHERE tg_id='{$_GET['id']}'";
    $result=mysqli_query($link,$sql);
    $_rows=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(!!$_rows){
        $_html=array();
        $_html['id']=$_rows['tg_id'];
        $_html['name']=$_rows['tg_name'];
        $_html['type']=$_rows['tg_type'];
        $_html['face']=$_rows['tg_face'];
        $_html['content']=$_rows['tg_content'];

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
        <script type="text/javascript" src="js/photo_add_dir.js"></script>
    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
        <div id="photo">
        <h2>修改相册目录</h2>
            <form method="post" action="?action=modify">

            <dl>
                <dd>相册名称：<input type="text" name="name" class="text" value="<?php echo $_html['name'] ?>"/> </dd>
                <dd>相册类型：<input type="radio" name="type" value="0" <?php if($_html['type']==0) echo 'checked="checked"';?>/>公开 <input type="radio" name="type" value="1" <?php if($_html['type']==1) echo 'checked="checked"';?> />私密 </dd>
                <dd id="pass" <?php if($_html['type']==1) echo 'style="display:block";' ?>>相册密码：<input type="password" name="password" class="text"/></dd>
                <dd>相册封面：<input type="text" name="face" value="<?php echo $_html['face'] ?>" class="text"/></dd>
                <dd>相册简介：<textarea name="content"><?php echo $_html['content'] ?></textarea></dd>
                <dd><input type="submit" class="submit" value="修改目录"/> </dd>
            </dl>
                <input type="hidden" value="<?php echo $_html['id']?>" name="id"/>
            </form>

        </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
