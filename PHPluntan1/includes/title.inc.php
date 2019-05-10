
<?php
/**
 * Created by PhpStorm.
 * User: Tome
 * Date: 2019/1/31
 * Time: 13:33
 */
global $_system;
if(!defined('IN_TG')) {
    exit ('Access Defined!');
}
//防止非HTML页面调用
if(!defined('SCRIPT'))
{
    exit('Script Error');
}



?>
<title><?php echo $_system['webname'] ?></title>
<link rel="shortcut icon" href="../doc.jpg"/>
<link rel="stylesheet" type="text/css" href="style/<?php echo $_system['skin'] ?>/basic.css"/>
<link rel="stylesheet" type="text/css" href="style/<?php echo $_system['skin'] ?>/<?php echo SCRIPT?>.css"/>


