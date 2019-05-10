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
define('SCRIPT','member_modify');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';

//修改资料
if($_GET['action']=='modify') {
    //防止跨站攻击
    _check_code($_POST['code'], $_SESSION['code']);
    //引入注册文件
    include ROOT_PATH . './includes/register.func.php';
    $_clean = array();
    $_clean['password'] = _check_modify_password($_POST['password'], 6);
    $_clean['face'] = _check_face($_POST['face']);
    $_clean['email']=_check_email($_POST['email'],6,40);
    $_clean['qq'] = _check_qq($_POST['qq']);
    $_clean['url'] = _check_url($_POST['url'], 40);
    $_clean['switch'] = $_POST['switch'];
    $_clean['autograph'] = _check_autograph($_POST['autograph'], 200);

//修改密码
    if (empty($_clean['password'])) {
        $query = "update tg_user SET 
                                   tg_face='{$_clean['face']}',
                                   tg_url='{$_clean['url']}',
                                   tg_qq='{$_clean['qq']}',
                                   tg_email='{$_clean['email']}',
                                   tg_autograph='{$_clean['autograph']}',
                                   tg_switch='{$_clean['switch']}',
                                   tg_email='{$_clean['email']}'
                                  WHERE 
                                  tg_username='{$_COOKIE['username']}'";
    } else {
        $query = "update tg_user SET
                                   tg_password = '{$_clean['password']}',
                                   tg_face = '{$_clean['face']}',
                                   tg_email = '{$_clean['email']}',
                                   tg_qq = '{$_clean['qq']}',
                                   tg_url = '{$_clean['url']}',
                                   tg_autograph='{$_clean['autograph']}',
                                   tg_switch='{$_clean['switch']}',
                                   tg_email='{$_clean['email']}'
                                  
                                  WHERE 
                                  tg_username = '{$_COOKIE['username']}'";

    }
    $result = mysqli_query($link, $query);
    _location('恭喜您，修改成功','member.php');
}



     //判断是否修改成功
// if($dj==1){
//     _session_destroy();
//      _location('恭喜您，修改成功','member.php');
//   }else{
//     _location('很遗憾修改失败','member_modify.php');
// }





//是否正常登录
if(isset($_COOKIE['username'])){
    //获取数据
    $query="select tg_switch,tg_autograph,tg_username,tg_face,tg_email,tg_qq,tg_url from tg_user WHERE tg_username='{$_COOKIE['username']}'";
    $result=mysqli_query($link,$query);
    $row=mysqli_fetch_array($result);

if($row){
   $_html=array();
   $_html['username']=$row['tg_username'];
    $_html['face']=$row['tg_face'];
    $_html['email']=$row['tg_email'];
    $_html['qq']=$row['tg_qq'];
    $_html['url']=$row['tg_url'];
    $_html['switch']=$row['tg_switch'];
    $_html['autograph']=$row['tg_autograph'];

    //头像选择
    $_html['face_html']='<select name="face">';
    foreach (range(1,6)as $_num){
        $_html['face_html'].='<option value="face/mo'.$_num.'.jpg">face/mo'.$_num.'.jpg</option>';

    }
    $_html['face_html'].='</select>';
    //个性签名开关
    if($_html['switch']==1){
        $_html['switch_html']='<input type="radio" name="switch" value="1" checked="checked"/>启用 <input type="radio" name="switch" value="0" />禁用';
    }elseif($_html['switch']==0){
        $_html['switch_html']='<input type="radio" name="switch" value="1" />启用 <input type="radio" name="switch" value="0" checked="checked" />禁用';
    }

}else{
    _alert_back('此用户不存在');
}

}else{
    _alert_back('非法登录');
}
?>

<!DOCTYPE html>
<html>
<head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <?php
    require ROOT_PATH.'/includes/title.inc.php';
    ?>
  <script type="text/javascript" src="js/code.js"></scripttype></script>
    <script type="text/javascript" src="js/member_modify.js"></script>
</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
<?php require ROOT_PATH.'includes/member.inc.php'?>
    <div id="member_main">
      <h2>会员管理中心</h2>
        <form method="post" action="member_modify.php?action=modify">
        <dl>
            <dd>用 户 名：<?php echo $_html['username']?></dd>
            <dd> 头   像：<?php echo $_html['face_html']?></dd>
            <dd> 密   码：<label><input type="password" class="text" name="password" />留空则不修改 </label></dd>
            <dd>电子邮件：<label><input type="text" class="text" name="email" value="<?php echo $_html['email']?>" </label></dd>
            <dd>主    页：<label><input type="text" class="text" name="url" value="<?php echo $_html['url']?>"</label></dd>
            <dd>Q      Q：<label><input type="text" class="text" name="qq" value="<?php echo $_html['qq']?>"</label></dd>
            <dd>个性签名：<?php echo $_html['switch_html'] ?></dd>
            <dd><p><textarea name="autograph"><?php echo $_html['autograph'] ?></textarea></p></dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> <input type="submit" class="submit" value="修改资料" /> </label></dd>







        </dl>
    </div>






<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
