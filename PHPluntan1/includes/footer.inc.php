<!--<div id="footer">-->
<!--    <p>版权所有翻版必究</p>-->
<!--    <p>本程序由<span>DJ</span>提供源代码可以任意修改或发布（c）yc60.com</p>-->
<!--</div>-->

<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/30
 * Time: 11:45
 */if(!defined('IN_TG')) {
    exit ('Access Defined!');
}

if(PHP_VERSION<'5.1.0'){
    exit('Version is to low');
}
$_end_time=_runtime();
mysqli_close($link);
?>

     <div id="footer">
        <p>本程序耗时<?php echo $_end_time-$_start_time ?>秒</p>
    <p>版权所有翻版必究</p>
    <p>本程序由<span>DJ</span>提供源代码可以任意修改或发布（c）yc60.com</p>
</div>


