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
define('SCRIPT','manage');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//必须是管理员才能登陆
_manage_login();
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
        <dl>
            <dd>*服务器主机名称：<?php echo $_SERVER['SERVER_NAME']; ?></dd>
<!--            <dd>*服务器版本：--><?php //echo $_ENV['OS']; ?><!--</dd>-->
            <dd>*通信协议名称/版本：<?php echo $_SERVER['SERVER_PROTOCOL']; ?></dd>
            <dd>*服务器IP：<?php echo $_SERVER["SERVER_ADDR"]; ?></dd>
            <dd>*客户端IP：：<?php echo $_SERVER["REMOTE_ADDR"]; ?></dd>
            <dd>*服务器端口：<?php echo $_SERVER['SERVER_PORT']; ?></dd>
            <dd>*客户端端口：<?php echo $_SERVER['REMOTE_PORT']; ?></dd>
            <dd>*HOST头部的内容：<?php echo $_SERVER['HTTP_HOST']; ?></dd>
            <dd>*服务器主目录：<?php echo $_SERVER['DOCUMENT_ROOT']; ?></dd>
<!--            <dd>*服务器统盘：--><?php //echo $_ENV["SystemRoot"]; ?><!--</dd>-->
            <dd>*脚本执行的绝对路径：<?php echo $_SERVER['SCRIPT_FILENAME']; ?></dd>
            <dd>*Apache及PHP版本：<?php echo $_SERVER['SERVER_SOFTWARE']; ?></dd>
        </dl>
    </div>






<?php
require ROOT_PATH.'includes/footer.inc.php';
?>
</body>
</html>
