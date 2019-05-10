<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/13
 * Time: 14:41
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','manage_set');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//必须是管理员才能登陆
_manage_login();
//修改系统表
if($_GET['action']=='set'){
    $_clean=array();
    $_clean['webname']=$_POST['webname'];
    $_clean['article']=$_POST['article'];
    $_clean['blog']=$_POST['blog'];
    $_clean['photo']=$_POST['photo'];
    $_clean['skin']=$_POST['skin'];
    $_clean['string']=$_POST['string'];
    $_clean['post']=$_POST['post'];
    $_clean['re']=$_POST['re'];
    $_clean['code']=$_POST['code'];
    $_clean['register']=$_POST['register'];
    //写入数据库
    $sql="update tg_system SET 
                              tg_webname='{$_clean['webname']}',
                              tg_article='{$_clean['article']}',
                              tg_blog='{$_clean['blog']}',
                              tg_photo='{$_clean['photo']}',
                              tg_skin='{$_clean['skin']}',
                              tg_string='{$_clean['string']}',
                              tg_post='{$_clean['post']}',
                              tg_re='{$_clean['re']}',
                              tg_code='{$_clean['code']}',
                              tg_register='{$_clean['register']}'                            
                             where tg_id=1
                             LIMIT 1
                              ";
    //执行SQL
    mysqli_query($link,$sql);
    if(mysqli_affected_rows($link)==1){
        _location('修改成功','manage_set.php');
    }else{
        _location('修改失败','manage_set.php');
    }
}
//读取系统表
$sql="select * from tg_system WHERE tg_id=1 LIMIT 1";
$result=mysqli_query($link,$sql);
$row=mysqli_fetch_array($result);
if(!!$row){
        $_html=array();
        $_html['webname']=$row['tg_webname'];
        $_html['blog']=$row['tg_blog'];
        $_html['article']=$row['tg_article'];
        $_html['photo']=$row['tg_photo'];
        $_html['skin']=$row['tg_skin'];
        $_html['string']=$row['tg_string'];
        $_html['post']=$row['tg_post'];
        $_html['re']=$row['tg_re'];
        $_html['code']=$row['tg_code'];
        $_html['register']=$row['tg_register'];
        //文章
        if($_html['article']==5){
            $_html['article']='<select name="article"><option value="5" selected="selected">每页5篇</option><option value="6">每页6篇</option></select>';
        }elseif($_html['article']==6){
            $_html['article']='<select name="article"><option value="5" >每页5篇</option><option value="6" selected="selected">每页6篇</option></select>';
        }
        //博友
    if($_html['blog']==5){
        $_html['blog']='<select name="blog"><option value="5" selected="selected">每页5人</option><option       value="10">每页10人</option></select>';
    }elseif($_html['blog']==10){
        $_html['blog']='<select name="blog"><option value="5" >每页5人</option><option value="10" selected="selected">每页10人</option></select>';
    }
        //相册
    if($_html['photo']==8){
        $_html['photo']='<select name="photo"><option value="8" selected="selected">每页8张</option><option value="12">每页12张</option></select>';
    }elseif($_html['photo']==12){
        $_html['photo']='<select name="photo"><option value="8" >每页8张</option><option value="12" selected="selected">每页12张</option></select>';
    }
        //皮肤
if($_html['skin']==1){
    $_html['skin']='<select name="skin"><option value="1" selected="selected">1号皮肤</option><option value="2">2号皮肤</option></select>';
}elseif($_html['skin']==2) {
    $_html['skin'] = '<select name="skin"><option value="2" >1号皮肤</option><option value="2" selected="selected">2号皮肤</option></select>';
}
        //发帖
    if($_html['post']==30){
            $_html['post_html']='<input type="radio" name="post" value="30" checked="checked"/> 30秒 <input type="radio" name="post" value="60"/> 60秒 <input type="radio" name="post" value="180"/> 180秒';
    }elseif($_html['post']==60){
        $_html['post_html']='<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" checked="checked"/> 60秒 <input type="radio" name="post" value="180"/> 180秒';
    }elseif($_html['post']==180){
        $_html['post_html']='<input type="radio" name="post" value="30" /> 30秒 <input type="radio" name="post" value="60" /> 60秒 <input type="radio" name="post" value="180" checked="checked"/> 180秒';
    }
        //回帖
if($_html['re']==15) {
    $_html['re_html'] = '<input type="radio" name="re" value="15" checked="checked"/> 15秒 <input type="radio" name="re" value="30"/> 30秒 <input type="radio" name="re" value="45"/> 45秒';
}elseif($_html['re']==30){
    $_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" checked="checked"/> 30秒 <input type="radio" name="re" value="45"/> 45秒';
}elseif($_html['re']==45){
    $_html['re_html'] = '<input type="radio" name="re" value="15" /> 15秒 <input type="radio" name="re" value="30" /> 30秒 <input type="radio" name="re" value="45" checked="checked"/> 45秒';
}
        //验证码
    if($_html['code_code']==1){
        $_html['code_html'] = '<input type="radio" name="code" value="1" checked="checked" /> 启用 <input type="radio" name="code" value="0" /> 关闭';
    }else{
        $_html['code_html'] = '<input type="radio" name="code" value="1" /> 启用 <input type="radio" name="code" value="0" checked="checked"/> 关闭';
    }
        //开放注册
    if($_html['register']){
        $_html['register_html'] = '<input type="radio" name="register" value="1" checked="checked" /> 开放 <input type="radio" name="register" value="0" /> 关闭';
    }else{
        $_html['register_html'] = '<input type="radio" name="register" value="1" " /> 开放 <input type="radio" name="register" value="0" checked="checked" /> 关闭';
    }

}else{
    _alert_back('系统表出现错误，请联系管理员检查');
}
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

<?php require ROOT_PATH.'includes/manage.inc.php'?>
    <div id="member_main">
      <h2>后台管理中心</h2>
        <form method="post" action="?action=set">
        <dl>
            <dd>*网 站 名 称：<input type="text" name="webname" class="text" value="<?php echo $_html['webname'] ?>"/></dd>
            <dd>*文章每页列表数：<?php echo $_html['article'] ?></dd>
            <dd>*博客每页列表数：<?php echo $_html['blog'] ?></dd>
            <dd>*相册每页列表数：<?php echo $_html['photo'] ?></dd>
            <dd>*站点 默认 皮肤：<?php echo $_html['skin'] ?></dd>
            <dd>*非法字符过滤：<input type="text" name="string" class="text" value="<?php echo $_html['string'] ?>"/></dd>
            <dd>*每次发帖限制：<?php echo $_html['post_html'] ?></dd>
            <dd>*每次回帖限制：<?php echo $_html['re_html'] ?></dd>
            <dd>*是否启用验证码：<?php echo $_html['code_html'] ?>(登录界面测试)</dd>
            <dd>*是否开放会员注册：<?php echo $_html['register_html'] ?></dd>
            <dd><input type="submit" value="修改系统设置" class="submit"/> </dd>
        </dl>
        </form>
    </div>



<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
