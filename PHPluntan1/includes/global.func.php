<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/31
 * Time: 9:53
 */
function _manage_login(){
    if((!isset($_COOKIE['username']))||(!isset($_SESSION['admin']))){
        _alert_back('非法登录');
    }
}


function _timed($_now_time,$_pre_time,$_second){
    if($_now_time-$_pre_time<$_second){
        _alert_back('请阁下休息一会再发帖');
    }
}



function _location($_info,$_url){
        if(!empty($_info)) {
            echo "<script type='text/javascript'>alert('$_info');location.href='$_url';</script>";
            exit();
        }else{
            header('Location:'.$_url);
        }

}
/*
 * 本函数为短信内容截取前8个字
 * */
function _title($_string,$_strlen){
    if(mb_strlen($_string,'utf-8')>$_strlen){
        $_string=mb_substr($_string,0,$_strlen,'utf-8').'...';
    }
    return $_string;
}



/**
 * _rentime()是用来获取执行耗时
 * @access public 表示函数对外公开
 * @return float 表示返回出来的是一个浮点型数字
 */
function _runtime(){
    $_mtime = explode('|',microtime());
    return $_mtime[1]+$_mtime[0];
}
/*_alert_back()表示JS弹窗
 * @access public
 * @param $_info
 *@return void 弹窗
 */

function _alert_back($_info){
    echo "<script type='text/javascript'>alert('".$_info."');history.back();</script>";
    exit();
}

function _alert_close($_info){
    echo "<script type='text/javascript'>alert('".$_info."');history.close();</script>";
    exit();
}

function _check_code($_first_code,$_end_code){
    if($_first_code!=$_end_code){
        _alert_back('验证码不正确');
    }
}

function _sha1_uniqid(){
    return sha1(uniqid(rand(),true));
}


function _mysql_string($_string){
    //创建数据库连接
    $link =mysqli_connect('localhost','root','123456','testguest');
    if(!$link){
        die('can not connect'.mysqli_error($link));
    }else{
        //echo "数据库连接成功";
    }
    //get_magic_quotes_gpc()如果开启状态，那就不需要转义
    if(!GPC){
        return mysqli_real_escape_string($link,$_string);
    }
        return $_string;

}
function _pading($_type){
    if($_type==1){

    }else if($_type==2){

    }
}




function _session_destroy(){
    if(session_start()) {
        session_destroy();
    }
}
function _unsetcookies(){
    setcookie('username','',time()-1);
    setcookie('uniqid','',time()-1);
    _session_destroy();
    _location(null,'dj.php');
}

function _login_state(){
    if(isset($_cookie['username'])){
        _alert_back('登录状态无法进行本操作');
    }
}
/*
 * _html()表示对字符串进行HTML过滤显示，如果是数组按数组的方式过滤，如果是单独的字符串，那么就按字符串来处理
 *@param unknown_type $_string
 */
function _html($_string)
{
    if (is_array($_string)) {
        foreach ($_string as $_key => $_value) {
            $_string[$_key] = _html($_value);//采用了递归
        }
    } else {
        $_string = htmlspecialchars($_string);
    }
    return $_string;
}

 function _thumb($_filename,$_percent){
     //生成PNG标头文件
     header('Content-type:image/png');
     $_n=explode('.',$_filename);
//获取文件信息，长和高
     list($_width,$_height)=getimagesize($_filename);
//生成微缩的长和高
     $_new_width=$_width*$_percent;
     $_new_height=$_height*$_percent;
//创建一个以0.3百分比新长度的画布
     $_new_image=imagecreatetruecolor($_new_width,$_new_height);
//按照已有的图片创建一个画布
     switch($_n[1]){
         case'jpg': $_image=imagecreatefromjpeg($_filename);
             break;
         case'png': $_image=imagecreatefrompng($_filename);
             break;
         case'gif': $_image=imagecreatefromgif($_filename);
             break;
     }
//将原图采集后重新复制到新图上
     imagecopyresampled($_new_image,$_image,0,0,0,0,$_new_width,$_new_height,$_width,$_height);
     imagepng($_new_image);
     imagedestroy($_new_image);
     imagedestroy($_image);
 }


function _set_xml($_xmlfile,$_clean){
    $_fp=@fopen('new.xml','w');
    if(!$_fp){
        exit('系统错误，文件不存在');
    }
    flock($_fp,LOCK_EX);
    $_string="<?xml version=\"1.0\" encoding=\"utf-8\"?>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="<vip>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<id>{$_clean['id']}</id>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<username>{$_clean['username']}</username>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<face>{$_clean['face']}</face>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="\t<url>{$_clean['url']}</url>\r\n";
    fwrite($_fp,$_string,strlen($_string));
    $_string="</vip>";
    fwrite($_fp,$_string,strlen($_string));
    flock($_fp,LOCK_UN);
    fclose($_fp);
}

    function _get_xml($_xmlfile){
        //读取XML文件
        $_html=array();
        if(file_exists($_xmlfile)){
            $_xml=file_get_contents($_xmlfile);
            preg_match_all('/<vip>(.*)<\/vip>/s',$_xml,$_dom);
            foreach ($_dom[1] as $_value){
                preg_match_all('/<id>(.*)<\/id>/s',$_value,$_id);
                preg_match_all('/<username>(.*)<\/username>/s',$_value,$_username);
                preg_match_all('/<face>(.*)<\/face>/s',$_value,$_face);
                preg_match_all('/<url>(.*)<\/url>/s',$_value,$_url);

                $_html['id']=$_id[1][0];
                $_html['username']=$_username[1][0];
                $_html['face']=$_face[1][0];
                $_html['url']=$_url[1][0];

            }
        }else{
            echo '文件不存在';
        }
        return $_html;
    }
function _remove_Dir($dirName){
    if(!is_dir($dirName)){
        return false;
    }
    $handle=@opendir($dirName);
    while(($file=@readdir($handle))!==false){
        if($file!='.'&&$file!='..'){
            $dir=$dirName.'/'.$file;
            is_dir($dir)?_remove_Dir($dir):@unlink($dir);
        }
    }
    closedir($handle);
    return rmdir($dirName);


}




?>