<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/1
 * Time: 18:30
 */
$_first_pass=0;
$_end_pass=0;
$_min_num=0;

if(!defined('IN_TG')) {
    exit ('Access Defined!');
}

if(!function_exists('_alert_back')) {
    exit('_alert_back()函数不存在，请检查！');
}
function _check_uniqid($_first_uniqid,$_end_uniqid){
  if((strlen($_first_uniqid)!=40)||($_first_uniqid!=$_end_uniqid)){
      _alert_back('唯一标识符异常');
  }
  return $_first_uniqid;
 // echo $_first_uniqid.'/n'.$_end_uniqid;
   //_alert_back($_first_uniqid.'\n'.$_end_uniqid);
}


function _check_password($_first_pass,$_end_pass,$_min_num)
{
//判断密码
    if (strlen($_first_pass) < $_min_num) {
        _alert_back('密码不得小于6位' . $_min_num);
    }

    //密码和密码确认必须一致
    if ($_first_pass != $_end_pass) {
        _alert_back('密码和确认密码不一致');
    }
    //将密码返回
    return sha1($_first_pass);
}

function _check_modify_password($_string,$_min_num){
    if(!empty($_string)) {
        if (strlen($_string) < $_min_num) {
            _alert_back('密码不得小于6位' . $_min_num);
        }
    }else{
        return null;
    }
    return sha1($_string);
}
        function _check_question($_string,$_min_num,$_max_num){
    //长度小于4位或者大于20位
    if(mb_strlen($_string,'utf-8')<$_min_num||mb_strlen($_string,'utf-8')>$_max_num){

        _alert_back('密码提示不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
    }
    //返回密码提示
            return $_string;
}

        function _check_answer($_ques,$_answ,$_min_num,$_max_num){

            if(mb_strlen($_ques ,'utf-8')<$_min_num||mb_strlen($_answ,'utf-8')>$_max_num){

                _alert_back('密码回答不得小于'.$_min_num.'位或者大于'.$_max_num.'位');
            }
            //密码提示与回答不能一致
            if($_ques==$_answ){
                _alert_back('密码提示与回答不得一致');
            }
            //加密返回
            return sha1($_answ);
        }

        function _check_sex($_string){
            return $_string;
        }

        function _check_face($_string){
            return $_string;
        }

        function _check_email($_string,$_min_num,$_max_num){
        if(empty($_string)) {
            return null;
        }else {

            //参考dd@163.com
            if (!preg_match('/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,})$/', $_string)) {
                _alert_back('邮件格式不正确');

                if(strlen($_string)<$_min_num||strlen($_string)>$_max_num){
                    _alert_back('邮箱长度不合法');
                }
            }
        }


    return $_string;

        }

        function _check_qq($_string)
        {
            if (empty($_string)) {
                return null;
            }else {
                if (!preg_match('/^[1-9]{1}[0-9]{4,9}$/', $_string)) {
                    _alert_back('qq不正确');

                }
            }
                return $_string;

        }
        function _check_url($_string,$_max_num){
        if(empty($_string)||($_string=='http://')){
            return null;
        }else{
            //http://www.yc60.com
            //?表示0次或者1次
            if(!preg_match('/^https?:\/\/(\w+\.)?[\w\-\.]+(\.\w+)+$/',$_string)){
                _alert_back('网址不正确');
            }
                if(strlen($_string)>$_max_num){
                 _alert_back('网址太长');
                }
        }
    return $_string;
        } 


function _check_username($_string,$_min_num,$_max_num){
    global $_system;
    //去掉两边的空格
    $_string=trim($_string);

    //长度小于2位或者大于20位都不行
    if(mb_strlen($_string,'utf-8')<$_min_num||mb_strlen($_string,'utf-8')>$_max_num){

            _alert_back('用户名长度小于2位或者大于20位');
        }

        //限制敏感字符
    $_char_pattern='/[<>\'\"\\ ]/';
if(preg_match($_char_pattern,$_string)){
    _alert_back('用户名不得包含敏感字符');
}

//限制敏感用户名
//    $_mg[0]='戴杰';
////    $_mg[1]='DJ';
        $_mg=explode('|',$_system['string']);
//告诉用户那些用户名不能注册
    foreach($_mg as $value){
         $_mg_string='';
         $_mg_string .=$value;
    }
    //这里采用的绝对匹配
    if(in_array($_string,$_mg))
    {
        _alert_back($_mg_string.'敏感用户名不能注册');
    }

//将用户转义输入
    return $_string;
}

function _check_content($_string){
    if(mb_strlen($_string,'utf-8')<10||mb_strlen($_string,'utf-8')>200){
        _alert_back('短信内容不得小于10位或者大于200位');
    }
    return $_string;
}

function _check_post_title($_string,$_min,$_max){
if(mb_strlen($_string,'utf-8')<$_min||mb_strlen($_string,'utf-8')>$_max){
    _alert_back('标题字数不得小于'.$_min.'位大于'.$_max.'位');
}
return $_string;
}

function _check_post_content($_string,$_num){
    if(mb_strlen($_string,'utf-8')<$_num){
        _alert_back('内容字数不得小于'.$_num.'位');
    }
    return $_string;
}
function _check_autograph($_string,$_num){
    if(mb_strlen($_string,'utf-8')>$_num){
        _alert_back('内容字数不得大于'.$_num.'位');
    }
    return $_string;
}

function _check_dir_name($_string,$_min,$_max){
    if(mb_strlen($_string,'utf-8')<$_min||mb_strlen($_string,'utf-8')>$_max){
        _alert_back('名称数不得小于'.$_min.'位,不能小于'.$_max.'位');
    }
    return $_string;
}
function _check_dir_password($_string,$_num)
{
        if (strlen($_string) < $_num) {
            _alert_back('密码不得小于6位' . $_num);
            }
            return sha1($_string);

}
function _check_photo_url($_string){
    if(empty($_string)){
        _alert_back('地址不能为空');
    }
    return $_string;
}