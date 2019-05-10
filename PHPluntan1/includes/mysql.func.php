<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/2/12
 * Time: 8:51
 */

function _connect(){
    global $link;
    //创建数据库连接
    $link =mysqli_connect('localhost','root','123456','testguest');
    if(!$link){

        echo 'can not connect'.mysqli_connect_error();
    }else{
        echo "数据库连接成功";
        }
}
_connect();


