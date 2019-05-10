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
define('SCRIPT','register');

//判断是否提交

if($_GET['action']=='register'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);

        //引入验证文件
        include ROOT_PATH.'includes/register.func.php';
        //创建一个空数组，用来存放提交过来的合法数据
        $_clean =array();
    //可以通过唯一标识符来防止恶意注册，伪装表单跨站攻击
    //这个存放入数据库的唯一标识符还有第二个用处，就是登陆COOKIES验证

        $_clean['uniqid']=_check_uniqid($_POST['uniqid'],$_SESSION['uniqid']);
        //active也是一个唯一标识符，用来刚注册的用户进行数据激活处理，方可登陆
        $_clean['active']=_sha1_uniqid();
        $_clean['username']=_check_username($_POST['username'],2,20);
        $_clean['password']=_check_password($_POST['password'],$_POST['notpassword'],6);
        $_clean['question']=_check_question($_POST['question'],2,20);
        $_clean['answer']=_check_answer($_POST['question'],$_POST['answer'],2,20);
        $_clean['sex']=_check_sex($_POST['sex']);
        $_clean['face']=_check_face($_POST['face']);
        $_clean['email']=_check_email($_POST['email'],6,40);
        $_clean['qq']=_check_qq($_POST['qq']);
        $_clean['url']=_check_url($_POST['url'],40);
        //新增之前判断用户名是否重复
    $query="select tg_username from tg_user where tg_username='{$_clean['username']}'";
    $result=mysqli_query($link,$query);
   if(mysqli_fetch_array($result,MYSQLI_ASSOC)){
       _alert_back('用户名已被注册');
    }

//新增用户
    $query = "insert into tg_user (
                                   tg_uniqid,
                                   tg_active,
                                   tg_username,
                                   tg_password,
                                   tg_question,
                                   tg_answer,
                                   tg_sex,
                                   tg_face,
                                   tg_email,
                                   tg_qq,
                                   tg_url,
                                   tg_reg_time,
                                   tg_last_time,
                                   tg_last_ip                                 
                                  ) 
                                  values(
                                     '{$_clean['uniqid']}',
                                     '{$_clean['active']}',
                                     '{$_clean['username']}',
                                     '{$_clean['password']}',
                                     '{$_clean['question']}',
                                     '{$_clean['answer']}',
                                     '{$_clean['sex']}',
                                     '{$_clean['face']}',
                                     '{$_clean['email']}',
                                     '{$_clean['qq']}',
                                     '{$_clean['url']}',
                                     NOW(),
                                     NOW(),
                                     '{$_SERVER["REMOTE_ADDR"]}'
                                     
                                     
                                        )";

    $result =mysqli_query($link,$query);
        //获取新增的ID
        $_clean['id']=mysqli_insert_id($link);
        //关闭数据库
        mysqli_close($link);
        //生成xml
        _set_xml('new.xml',$_clean);
        //跳转
        _location('恭喜你，注册成功！','login.php');

}else{
    $_SESSION['uniqid'] = $_uniqid = _sha1_uniqid();
}
?>


<!DOCTYPE html>
    <html>
    <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link rel="shortcut icon" href="doc.jpg"/>
    <link rel="stylesheet" type="text/css" href="style/1/basic.css"/>
    <link rel="stylesheet" type="text/css" href="style/1/register.css"/>
        <?php
        require ROOT_PATH.'/includes/title.inc.php';
        ?>
        <script type="text/javascript" src="js/code.js"></script>
        <script type="text/javascript" src="js/register.js"></script>
</head>
<body>
<?php

require ROOT_PATH.'includes/header.inc.php';
?>

<div id="register">
    <h2>会员注册</h2>
    <form method="post" name='register' action="register.php?action=register">
        <input type="hidden" name="uniqid" value="<?php echo $_uniqid?>">
        <dl>
        <dt>请认真填写以下内容</dt>
        <dd>用户名：  <label><input type="text" name="username" class="text"/> </label>(*必填，至少2位)</dd>
        <dd>    密     码      ：<label><input type="password" name="password" class="text"/>(*必填，至少2位)</label> </dd>
        <dd>确认密码：<label><input type="password" name="notpassword" class="text"/> (*必填，同上) </label></dd>
        <dd>密码提示：<label><input type="text" name="question" class="text"/> (*必填，至少2位) </label></dd>
        <dd>密码回答：<label><input type="text" name="answer" class="text"/> (*必填，至少2位) </label></dd>
        <dd>性   别：<label><input type="radio" name="sex" value="男" checked="checked"/>男</label> <label><input type="radio" name="sex" value="女" /></label>女</dd>
        <dd class="face"><input type="hidden" name="face" value="face/mo1.jpg" /><img src="face/mo1.jpg" alt="头像选择" id="faceimg"/></dd>
            <dd>电子邮件：<label><input type="text" name="email" class="text"/></label> </dd>
            <dd>  Q Q  ：<label><input type="text" name="qq" class="text"/> </label></dd>
            <dd>主页地址：<label><input type="text" name="url" class="text" value="http://"/> </label></dd>
            <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> </label></dd>
            <dd><label><input type="submit" class="submit" value="注册" /></label></dd>

        </dl>
    </form>
</div>

<?php
  require ROOT_PATH.'includes/footer.inc.php';
  ?>
</body>
</html>
