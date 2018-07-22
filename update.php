<?php
/**
 * 补全电话邮箱
 * @param  $_POST['userid']:necessary $_POST['tel']:optional $_POST['email']:optional
 * @return int
 * -1:no login
 * -2:no data comes here
 */
session_start();
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_SESSION['userid']))
{
    $res1=isset($_POST['email'])?change_email($_SESSION['stunum'],$_POST['email']):-2;
    $res2=isset($_POST['tel'])?change_tel($_SESSION['stunum'],$_POST['tel']):-2;
    $res3=isset($_POST['new_password'])?change_password($_SESSION['stunum'],$_POST['new_password']):-1;
    echo json_encode(array(
        "change_email"=>$res1,
        "change_tel"=>$res2,
        "change_password"=>$res3,
    ));
}
else echo json_encode(array(
    "change_email"=>-1,
    "change_tel"=>-1,
    "change_password"=>-1,
));
?>