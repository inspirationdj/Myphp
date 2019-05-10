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
define('SCRIPT','face');

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
<div id="face">
    <h3>选择头像</h3>
    <dl>
        <?php
        foreach (range(1,6)as $num){?>

        <dd><img src="face/mo<?php echo $num?>.jpg" alt="face/mo<?php echo $num?>.jpg"  title="头像<?php echo $num?>" /></dd>

        <?php } ?>
    </dl>
</div>

</body>
</html>
<?php
require ROOT_PATH.'/includes/title.inc.php';
?>
