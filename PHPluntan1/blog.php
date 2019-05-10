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
define('SCRIPT','blog');
//全局
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
?>

<!DOCTYPE html>
    <html>
    <head>

    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

<?php
require ROOT_PATH.'/includes/title.inc.php';
?>
        <script type="text/javascript" src="js/blog.js"></script>
    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
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

    $_pagesize=$_system['blog'];
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
    //从数据库中提取数据
    $query="select tg_username,tg_id,tg_face from tg_user ORDER BY tg_reg_time DESC LIMIT $_pagenum,$_pagesize ";
    $result=mysqli_query($link,$query);

    ?>
    <div id="blog">
        <h2>博友列表</h2>

        <?php
            $_html=array();
        while(@$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
            $_html['id']=$row['tg_id'];
            $_html['username']=$row['tg_username'];
            $_html['face']=$row['tg_face'];
            $_html['sex']=$row['tg_sex'];
            //$_html=$_html($_html);
            ?>
        <dl>
            <dd class="user"><?php echo $row['tg_username'] ?></dd>
            <dt><img src="<?php echo $row['tg_face']?>" alt="呆呆呆"</dt>
            <dd class="message"><a href="javascript:;" name="message" title="<?php echo $row['tg_id'] ?>">发消息</a></dd>
            <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $row['tg_id'] ?>">加好友</a></dd>
            <dd class="guest">写留言</dd>
            <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $row['tg_id'] ?>">送花朵</a></dd>
        </dl>
        <?php }
            mysqli_free_result($result);

        ?>
        <div id="page_num">
                    <ul>
                        <?php
                        for($i=0;$i<$_pageabsolute;$i++){
                            echo '<li><a href="'.SCRIPT.'.php?page='.($i+1).'">'.($i+1).'</a></li>';
                        }

                        ?>

            </ul>
        </div>
        <div id="page_text">
        <ul>
            <li><?php echo $_page ?>/<?php echo $_pageabsolute ?>页 |</li>
            <li> 共有<strong><?php echo $_num?></strong>个会员 |</li>
            <?php
            if($_page==1){
                echo '<li> 首页 |</li>';
                echo '<li> 上一页 |</li>';


            }else{
                echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'"> 首页 |</a></li> ';
                echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?page='.($_page-1).'"> 上一页 |</a></li> ';
            }
            if($_page==$_pageabsolute){
                echo '<li> 下一页 |</li>';
                echo '<li> 尾页 |</li>';

            }else{
                echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?page='.($_page+1).'"> 下一页 |</a></li> ';
                echo '<li><a href="'.$_SERVER["SCRIPT_NAME"].'?page='.($_pageabsolute).'"> 尾页 |</a></li> ';

            }







            ?>
        </ul>
        </div>

    </div>

    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
