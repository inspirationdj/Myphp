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
//添加目录
if($_GET['action']=='adddir'){
    $sql="select tg_uniqid FROM tg_user WHERE tg_username='{$_COOKIE['username']}' LIMIT 1";
    $result=mysqli_query($link,$sql);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(!!$row){
        _check_uniqid($row['tg_uniqid'],$_COOKIE['uniqid']);
        //接受数据
        $_clean=array();
        $_clean['name']=_check_dir_name($_POST['name'],2,20);
        $_clean['type']=$_POST['type'];
        if($_clean['type']==1) {
            $_clean['password'] = _check_dir_password($_POST['password'],6);
        }
        $_clean['content']=$_POST['content'];
        $_clean['dir']=time();
        //先检查主目录是否存在
        if(!is_dir('photo')){
            mkdir('photo',0777);
        }
        //在主目录创建定义的相册目录
        if(!is_dir('photo/'.$_clean['dir'])) {
            mkdir('photo/' . $_clean['dir']);
        }
        //把当前目录信息写入数据库
        if($_clean['type']==0){
            $sql="insert into tg_dir(tg_name,
                                     tg_type,
                                     tg_content,
                                     tg_dir,
                                     tg_date
                                     ) 
                               values('{$_clean['name']}',
                                      '{$_clean['type']}',
                                      '{$_clean['content']}',
                                      'photo/{$_clean['dir']}',
                                       NOW()
                                      ) ";
            mysqli_query($link,$sql);
        }else{
            $sql="insert into tg_dir(tg_name,
                                     tg_type,
                                     tg_content,
                                     tg_dir,
                                     tg_date,
                                     tg_password
                                     ) 
                               values('{$_clean['name']}',
                                      '{$_clean['type']}',
                                      '{$_clean['content']}',
                                      'photo/{$_clean['dir']}',
                                       NOW(),
                                       '{$_clean['password']}'
                                      ) ";
            mysqli_query($link,$sql);
        }
        //目录添加成功
        if(mysqli_affected_rows($link)==1){
            _location('添加成功','photo.php');
        }else{
            _location('添加失败');
        }

    }else{
        _alert_back('非法操作');
    }



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
        <h2>添加相册目录</h2>
            <form method="post" action="?action=adddir">
            <dl>
                <dd>相册名称：<input type="text" name="name" class="text"/> </dd>
                <dd>相册类型：<input type="radio" name="type" value="0" checked="checked"/>公开 <input type="radio" name="type" value="1"/>私密 </dd>
                <dd id="pass">相册密码：<input type="password" name="password" class="text"/></dd>
                <dd>相册简介：<textarea name="content"></textarea></dd>
                <dd><input type="submit" class="submit" value="添加目录"/> </dd>
            </dl>
            </form>

        </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
