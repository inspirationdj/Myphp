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
define('SCRIPT','q');
//初始化
if(isset($_GET['num'])&&isset($_GET['path'])){
   if(!is_dir(ROOT_PATH.$_GET['path'])){
       _alert_back('非法操作');
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
    <script type="text/javascript" src="js/qopener.js"></script>
</head>
<body>
<div id="q">
    <h3>选择贴图</h3>
    <dl>
        <?php
        foreach (range(1,$_GET['num'])as $_num){?>

        <dd><img src="<?php echo $_GET['path'].$_num ?>.gif" alt="<?php echo $_GET['path'].$_num ?>.gif"  title="头像<?php echo $_num?>" /></dd>

        <?php } ?>
    </dl>
</div>

</body>
</html>
<?php
require ROOT_PATH.'/includes/title.inc.php';
?>
