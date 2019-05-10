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
define('SCRIPT','article');

//全局
global $_system;
//引入公共文件
require dirname(__FILE__).'./includes/common.inc.php';
//处理精华帖
if($_GET['action']=='real'&&isset($_SESSION['admin'])&&isset($_GET['on'])){
    //设置精华帖或者取消精华帖
    $a="update tg_article SET tg_real='{$_GET['on']}' WHERE tg_id='{$_GET['id']}'";
    $res=mysqli_query($link,$a);
    if(mysqli_affected_rows($link)==1){
        _location('成功','article.php?id='.$_GET['id']);
    }else{
        _alert_back('失败');
    }
}
//处理回帖
if($_GET['action']=='rearticle'){
    //防止恶意注册，跨站攻击
    _check_code($_POST['code'],$_SESSION['code']);
    _timed(time(),$_COOKIE['article_time'],$_system['re']);
    //接收数据
    $_clean=array();
    $_clean['reid']=$_POST['reid'];
    $_clean['type']=$_POST['type'];
    $_clean['title']=$_POST['title'];
    $_clean['content']=$_POST['content'];
    $_clean['username']=$_COOKIE['username'];
    //写入数据库
    $sql="insert into tg_article (tg_reid,
                                 tg_username,
                                 tg_title,
                                 tg_type,
                                 tg_content
                                 )
                                                                 
                          values('{$_clean['reid']}',
                                 '{$_clean['username']}',
                                 '{$_clean['title']}',
                                 '{$_clean['type']}',
                                 '{$_clean['content']}'                   
                                )";
            mysqli_query($link,$sql);
            echo mysqli_affected_rows($link);
            print_r($_clean);
          if(mysqli_affected_rows($link)==1){
              $sql="update tg_article set tg_commendcount=tg_commendcount+1 WHERE tg_reid=0 AND tg_id='{$_clean['reid']}'";
              mysqli_query($link,$sql);
           _session_destroy();
           setcookie('article_time',time());
            _location('回帖成功','article.php?id='.$_clean['reid']);
          }else{
            _alert_back('回帖失败');
           }


}
//读出数据
if(isset($_GET['id'])){
    $sql="select tg_real,tg_last_modify_date,tg_id,tg_username,tg_type,tg_content,tg_readcount,tg_commendcount,tg_title,tg_date from tg_article WHERE tg_reid=0 AND tg_id='{$_GET['id']}'";
    $result=mysqli_query($link,$sql);
    $_rows=mysqli_fetch_array($result);
    if($_rows){
        //累计阅读量
        $sql="update tg_article SET tg_readcount=tg_readcount+1 WHERE tg_id='{$_GET['id']}'";
        mysqli_query($link,$sql);
        $_html=array();
        $_html['reid']=$_rows['tg_id'];
        $_html['username']=$_rows['tg_username'];
        $_html['title']=$_rows['tg_title'];
        $_html['content']=$_rows['tg_content'];
        $_html['readcount']=$_rows['tg_readcount'];
        $_html['commendcount']=$_rows['tg_commendcount'];
        $_html['type']=$_rows['tg_type'];
        $_html['date']=$_rows['tg_date'];
        $_html['last_modify_date']=$_rows['tg_last_modify_date'];
        $_html['real']=$_rows['tg_real'];

        //创建一个全局变量，做一个带参的分页
        global $_id;
        $_id='id='.$_html['reid'].'&';
    //拿出用户名去查找用户信息
        $sql="select tg_switch,tg_autograph,tg_id,tg_face,tg_url FROM tg_user WHERE tg_username='{$_html['username']}'";
        $res=mysqli_query($link,$sql);
        if($_rows=mysqli_fetch_array($res)){
            //提取用户信息
            $_html['userid']=$_rows['tg_id'];
            $_html['face']=$_rows['tg_face'];
            $_html['url']=$_rows['tg_url'];
            $_html['switch']=$_rows['tg_switch'];
            $_html['autograph']=$_rows['tg_autograph'];
            //主题帖子修改
            if($_html['username']==$_COOKIE['username']){
                $_html['subject_modify']='[<a href="article_modify.php?id='.$_html['reid'].'">修改</a>]';
            }
            //读取最后修改信息
            if($_html['last_modify_date']!='0000-00-00 00:00:00'){
            $_html['last_modify_date_string']='本帖已由['.$_html['username'].']于'.$_html['last_modify_date'].'修改过';
            }
            //个性签名
            if($_html['switch']==1){
            $_html['autograph_html']='<p class="autograph">'.$_html['autograph'].'</p>';
            }
            //读取回帖
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

            $_pagesize=$_system['article'];
            $_pagenum=($_page-1)*$_pagesize;
            //首页要得到所有的数据总和
            $sql="select tg_id from tg_article WHERE tg_reid='{$_html['reid']}'";
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
            $query="select tg_username,tg_type,tg_title,tg_content,tg_date from tg_article WHERE tg_reid='{$_html['reid']}' ORDER BY tg_date ASC  LIMIT $_pagenum,$_pagesize ";
            $result=mysqli_query($link,$query);


        }else{
            //这个用户已被删除
        }
    }else{
        _alert_back('不存在这个主题');
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
        <script type="text/javascript" src="js/code.js"></script>
        <script type="text/javascript" src="js/article.js"></script>

    </head>
    <body>
    <?php
    require ROOT_PATH.'includes/header.inc.php';
    ?>
    <div id="article">
            <h2>帖子详情</h2>
        <?php if(!empty($_html['real'])){ ?>
        <img src="iamge/real.png" alt="精华帖" class="real">
        <?php } ?>

        <?php
        //浏览量达到5 评论量达到2为热帖
        if($_html['readcount']>=5&&$_html['commendcount']>=2){
            ?>
        <img src="iamge/hot.png" alt="热帖" class="hot">
        <?php }?>


            <div id="subject">
                <dl>
                    <dd class="user"><?php echo $_html['username']?>[楼主]</dd>
                    <dt><img src="<?php echo $_html['face'] ?>" </dt>
                    <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'] ?>">发消息</a></dd>
                    <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'] ?>">加好友</a></dd>
                    <dd class="guest">写留言</dd>
                    <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'] ?>">送花朵</a></dd>
                    <dd class="url">网址：<a href="<?php echo $_html['url'] ?>"target="_blank"><?php echo $_html['url'] ?></a></dd>

                </dl>

            </div>
            <div class="content">
                <div class="user">
                    <span>
                        <?php
                        if($_SESSION['admin']) {
                            if (empty($_html['real'])) {
                                ?>
                                <a href="article.php?action=real&on=1&id=<?php echo $_html['reid'] ?>">[设置精华帖]</a>
                            <?php } else {
                                ?>
                                <a href="article.php?action=real&on=0&id=<?php echo $_html['reid'] ?>">[取消精华帖]</a>
                            <?php }
                        }?>
                        <?php echo $_html['subject_modify'] ?>1#
                    </span><?php echo $_html['username'] ?> | 发表于 ：<?php echo $_html['date'] ?>
                </div>
                <h3>主题：<?php echo $_html['title'] ?></h3>
                <div class="detail">
                    <?php echo $_html['content'] ?>
                </div>
                <div class="read">
                    <p><?php echo  $_html['last_modify_date_string'] ?></p>
                    阅读量: (<?php echo $_html['readcount']?>) 评论量:（<?php echo $_html['commendcount']?>）
                </div>
            </div>

        <p class="line"></p>

            <?php
                $_i=2;
                while(@$row=mysqli_fetch_array($result,MYSQLI_ASSOC)){
                $_html['username']=$row['tg_username'];
                $_html['type']=$row['tg_type'];
                $_html['content']=$row['tg_content'];
                $_html['date']=$row['tg_date'];
                $_html['retitle']=$row['tg_title'];


            //拿出用户名去查找用户信息
            $sql="select tg_id,tg_face,tg_url FROM tg_user WHERE tg_username='{$_html['username']}'";
            $res=mysqli_query($link,$sql);
            if($_rows=mysqli_fetch_array($res)) {
                //提取用户信息
                $_html['userid'] = $_rows['tg_id'];
                $_html['face'] = $_rows['tg_face'];
                $_html['url'] = $_rows['tg_url'];
//                if($_i==2){
//                    if($_html['username']==$_html['username_subject']) {
//                        $_html['username_html'] =$_html['username'].'(楼主)';
//                    }else{
//                        $_html['username_html'] =$_html['username'].'(沙发)';
//                    }
//                }else{ $_html['username_html']=$_html['username'];
//                      }
            }else{
                //这个用户可能已经被删除
            }
            //跟帖回复



            ?>
        <div class="re">
            <div id="subject">
                <dl>
                    <dd class="user"><?php echo $_html['username'] ?>[沙发]</dd>
                    <dt><img src="<?php echo $_html['face'] ?>" </dt>
                    <dd class="message"><a href="javascript:;" name="message" title="<?php echo $_html['userid'] ?>">发消息</a></dd>
                    <dd class="friend"><a href="javascript:;" name="friend" title="<?php echo $_html['userid'] ?>">加好友</a></dd>
                    <dd class="guest">写留言</dd>
                    <dd class="flower"><a href="javascript:;" name="flower" title="<?php echo $_html['userid'] ?>">送花朵</a></dd>
                    <dd class="url">网址：<a href="<?php echo $_html['url'] ?>"target="_blank"><?php echo $_html['url'] ?></a></dd>

                </dl>

            </div>
            <div class="content">
                <div class="user">
                    <span><?php echo $_i+(($_page-1)*$_pagesize); ?>#</span><?php echo $_html['username'] ?> | 发表于 ：<?php echo $_html['date'] ?>';

                </div>
                <h3>主题：<?php echo $_html['retitle'] ?><span><a href="#ree" name="re" title="回复<?php echo $_i+(($_page-1)*$_pagesize); ?>楼的<?php echo $_html['username'] ?>" >[回复]</a></span></h3>
                <div class="detail">
                   <?php echo $_html['content'] ?>
                    <?php echo $_html['autograph_html'] ?>
                </div>
            </div>
            </div>
        <p class="line"></p>
            <?php
                 $_i++;
                }
            ?>
        <div id="page_num">
            <ul>
                <?php
                for($i=0;$i<$_pageabsolute;$i++){
                    echo '<li><a href="'.SCRIPT.'.php?'.$_id.'page='.($i+1).'">'.($i+1).'</a></li>';
                }

                ?>

            </ul>
        </div>
        <?php if(isset($_COOKIE['username'])) {?>
            <a name="ree"></a>
        <form method="post" action="?action=rearticle">
            <input type="hidden" name="reid" value="<?php echo $_html['reid'] ?>"/>
            <input type="hidden" name="type" value="<?php echo $_html['type'] ?>"/>
            <dl>
                <dd>标  题：<label><input type="text" name="title" class="text" value="RE:<?php echo $_html['title'] ?>"/> </label>(*必填，2-40位)</dd>
                <dd id="q">贴  图：<a href="javascript:;"> Q图系列[1] </a><a href="javascript:;"> Q图系列[2] </a> <a href="javascript:;">Q图系列[3]</a></dd>
                <dd>
                    <?php include ROOT_PATH.'includes/ubb.inc.php'   ?>
                    <textarea name="content"></textarea>
                </dd>
                <dd>验 证 码：<label><input type="text" name="code" class="text yzm" /> <img src="recode.php" id="code" /> <input type="submit" class="submit" value="发表帖子" /></label></dd>
            </dl>
        </form>
        <?php } ?>
    </div>




    <?php
    require ROOT_PATH.'includes/footer.inc.php';
    ?>
    </body>
</html>
