<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/15
 * Time: 9:52
 */
session_start();
//定义个常量，用来授权调用includes里面的文件
define('IN_TG',true);
//定义个常量，用来置顶本页的内容
define('SCRIPT','member_message_detail');
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//判断是否登录
if(!isset($_COOKIE['username'])){
    _alert_back('请先登录');
}
//删除短信模块
if($_GET['action']== 'delete' &&isset($_GET['id'])){
    //验证短信是否合法
        $query="select tg_id from tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1";
        $result=mysqli_query($link,$query);
        $row=mysqli_fetch_array($result);
    if(isset($row)){
//
//单删短信
        $sql="delete from tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1";
        mysqli_query($link,$sql);

        if(mysqli_affected_rows($link)==1){
            _session_destroy();
            _location('删除成功','member_message.php');
        }else{
            echo mysqli_affected_rows($link);
            _session_destroy();
            _alert_back('删除失败');
        }

        }else
            {
       _alert_back('此短信不存在');
   }

}
//处理ID
if(isset($_GET['id'])){
    //获取数据
    $dj="select tg_id,tg_fromuser,tg_content,tg_date,tg_state from tg_message WHERE tg_id='{$_GET['id']}' LIMIT 1";
    $dd=mysqli_query($link,$dj);
    $row=mysqli_fetch_array($dd);
    if($row){
        //将状态设置为1
        if(empty($row['tg_state'])){
            $sql="update tg_message set tg_state=1 WHERE tg_id='{$_GET['id']}' LIMIT 1";
            mysqli_query($link,$sql);
            if(!mysqli_affected_rows($link)){
                _alert_back('异常');
            }
        }
        $_html=array();
        $_html['fromuser']=$row['tg_fromuser'];
        $_html['content']=$row['tg_content'];
        $_html['date']=$row['tg_date'];
        $_html['id']=$row['tg_id'];
    }else{
    _alert_back('此短信不存在');
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
    <script type="text/javascript" src="js/member_message_detail.js"></script>
</head>
<body>
<?php
require ROOT_PATH.'includes/header.inc.php';
?>


<?php require ROOT_PATH.'includes/member.inc.php'?>
<div id="member_main">
    <h2>短信详情中心</h2>
    <dl>
        <form method="post">
        <dd>发 信 人：<?php echo $_html['fromuser'] ?></dd>
        <dd>内   容：<strong><?php echo $_html['content'] ?></strong></dd>
        <dd>发信时间：<?php echo $_html['date'] ?></dd>
        <dd class="button"><input type="button" value="返回列表" id="return"/><input type="button" value="删除短信" id="delete" name="<?php echo $_html['id'] ?> "</dd>
        </form>
    </dl>
</div>
    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
</body>
</html>

