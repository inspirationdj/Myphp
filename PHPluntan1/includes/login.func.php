<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/12
 * Time: 11:31
 */
if(!defined('IN_TG')) {
    exit ('Access Defined!');
}

if(!function_exists('_alert_back')) {
    exit('_alert_back()函数不存在，请检查！');
}
function _check_username($_string,$_min_num,$_max_num)
{
    //去掉两边的空格
    $_string = trim($_string);

    //长度小于2位或者大于20位都不行
    if (mb_strlen($_string, 'utf-8') < $_min_num || mb_strlen($_string, 'utf-8') > $_max_num) {

        _alert_back('长度小于2位或者大于20位');
    }

    //限制敏感字符
    $_char_pattern = '/[<>\'\"\\ ]/';
    if (preg_match($_char_pattern, $_string)) {
        _alert_back('用户名不得包含敏感字符');
    }

//将用户转义输入
    return $_string;
}

function _check_password($_string,$_min_num){
//判断密码
    if(strlen($_string)<$_min_num){
        _alert_back('密码不得小于6位'.$_min_num);
    }


    //将密码返回
    return sha1($_string);


}

function _check_time($_string){
    $_time=array('0','1','2','3');
    if(!in_array($_string,$_time)){
        _alert_back('保留方式出错');
    }
    return $_string;
}

function _setcookies($_username,$_uniqid,$_time){
    switch($_time) {
    case'0':
    setcookie('username', $_username,0);
    setcookie('uniqid', $_uniqid,0);
    break;
    case'1':
    setcookie('username', $_username,time()+86400);
    setcookie('uniqid', $_uniqid,time()+86400);
    break;
            case'2':
            setcookie('username', $_username,time()+604800);
            setcookie('uniqid', $_uniqid,time()+604800);
            break;
            case'3':
            setcookie('username', $_username,time()+2592000);
            setcookie('uniqid', $_uniqid,time()+2592000);
            break;



    }
}