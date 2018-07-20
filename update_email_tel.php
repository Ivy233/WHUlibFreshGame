<?php
/**
 * 补全电话邮箱
 * @param  $_POST['userid']:necessary $_POST['tel']:optional $_POST['email']:optional
 * @return int
 * -2:nothing comes here
 */
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_POST['userid'])&&(isset($_POST['tel'])||isset($_POST['email'])))
{
    $db->update("user_basic",array(
        "tel"=>$_POST['tel'],
        "email"=>$user['email'],
    ),"id='".$_POST['userid']."'");
}
else echo -2;
?>