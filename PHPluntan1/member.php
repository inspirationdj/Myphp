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
define('SCRIPT','member');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//是否正常登录
if(isset($_COOKIE['username'])){
    //获取数据
    $query="select tg_username,tg_face,tg_email,tg_qq,tg_url,tg_reg_time,tg_level from tg_user WHERE tg_username='{$_COOKIE['username']}'";
    $result=mysqli_query($link,$query);
    $row=mysqli_fetch_array($result);

if($row){
   $_html=array();
   $_html['username']=$row['tg_username'];
    $_html['face']=$row['tg_face'];
    $_html['email']=$row['tg_email'];
    $_html['qq']=$row['tg_qq'];
    $_html['url']=$row['tg_url'];
    $_html['reg_time']=$row['tg_reg_time'];

    switch ($row['tg_level']){
        case 0:
            $_html['level']='普通会员';
            break;
        case 1:
            $_html['level']='管理员';
            break;
        default:$_html['level']='出错';

    }
    $_html=_html($_html);
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

</head>
<body>
<?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>

<?php require ROOT_PATH.'includes/member.inc.php'?>
    <div id="member_main">
      <h2>会员管理中心</h2>
        <dl>
            <dd>用 户 名：<?php echo $_html['username']?></dd>
            <dd> 头   像：<?php echo $_html['face']?></dd>
            <dd>电子邮件：<?php echo $_html['email']?></dd>
            <dd>主    页：<?php echo $_html['url']?></dd>
            <dd>Q      Q：<?php echo $_html['qq']?> </dd>
            <dd>注册时间：<?php echo $_html['reg_time']?></dd>
            <dd>身    份：<?php echo $_html['level']?></dd>





        </dl>
    </div>






<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
