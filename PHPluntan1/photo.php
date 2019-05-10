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
define('SCRIPT','photo');
//全局
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//删除目录
if($_GET['action']=='delete'&& isset($_GET['id'])){
    //删除目录
    $res=mysqli_query($link,"select tg_dir FROM tg_dir WHERE tg_id='{$_GET['id']}' LIMIT 1");
    if(!!$rows=mysqli_fetch_array($res)){
        $_html=array();
        $_html['url']=$rows['tg_dir'];
        //3.删除磁盘的目录
        if(file_exists($_html['url'])){
            if(_remove_Dir($_html['url'])){
                //1.删除目录里的数据库图片
                $sql="DELETE FROM tg_photo WHERE tg_sid='{$_GET['id']}'";
                mysqli_query($link,$sql);
                //2.删除目录的数据库
                $sq="DELETE FROM tg_dir WHERE tg_id='{$_GET['id']}'";
                mysqli_query($link,$sq);
                _alert_back('目录删除成功');
            }else{
                _alert_back('目录删除失败');
            }
        }
    }else{
        _alert_back('不存在此目录');
    }



}
//分页模块
if(isset($_GET['page'])){
    $_page=$_GET['page'];
    if(empty($_page)||$_page<0||!is_numeric($_page)){
        $_page=1;
    }else{
        $_page=intval($_page);
    }
}else{
    $_page=1;
}

$_pagesize=$_system['photo'];
$_pagenum=($_page-1)*$_pagesize;
//首页要得到所有的数据总和
$sql="select tg_face from tg_user";
$result=mysqli_query($link,$sql);
$_num=$res=mysqli_num_rows($result);

//容错处理 数据库请0
if($_num==0){
    $_pageabsolute=1;
}else{
    $_pageabsolute=ceil($_num/$_pagesize);
}
//num>总页码
if($_page>$_pageabsolute){
    $_page=$_pageabsolute;
}
//读取数据
$query="select tg_face,tg_name,tg_id,tg_type from tg_dir ORDER BY tg_date DESC LIMIT $_pagenum,$_pagesize ";
$result=mysqli_query($link,$query);
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
        <div id="photo">
        <h2>相册列表</h2>
            <?php
            $_html=array();
            while(@$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $_html['id']=$row['tg_id'];
            $_html['face']=$row['tg_face'];
            $_html['name']=$row['tg_name'];
            $_html['type']=$row['tg_type'];
            if($_html['type']==0){
                $_html['type_html']='(公开)';
            }else{
                $_html['type_html']='(私密)';
            }
            if(empty($_html['face'])){
                $_html['face_html']='';
            }else{
                $_html['face_html']='<img src="'.$_html['face'].'" alt="'.$_html['name'].'"/>';
            }
            //统计相册里的照片数量
                $sql="select count(*) AS count FROM tg_photo WHERE tg_sid={$_html['id']}";
                $res=mysqli_query($link,$sql);
                $_html['photo']=mysqli_fetch_array($res,MYSQLI_ASSOC);


            ?>
            <dl>
                <dt><a href="photo_show.php?id=<?php echo $_html['id'] ?>"><?php echo $_html['face_html'] ?></a></dt>
                <dd><a href="photo_show.php?id=<?php echo $_html['id'] ?>"> <?php echo $_html['name']?> <?php echo '['.$_html['photo']['count'].']',$_html['type_html'] ?></a></dd>
                <?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])){ ?>
                    <dd>[<a href="photo_modify_dir.php?id=<?php echo $_html['id']?>">修改</a>]<a href="photo.php?action=delete&id=<?php echo $_html['id'] ?>">[删除]</a></dd>
                <?php } ?>
            </dl>
            <?php } ?>
            <?php if(isset($_SESSION['admin'])&&isset($_COOKIE['username'])) {?>
            <p><a href="photo_add_dir.php">添加目录</a> </p>
            <?php } ?>
        </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
