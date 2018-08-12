<?php
/**
 * 补全电话邮箱
 * @param  $_POST['tel']:optional $_POST['email']:optional $_POST['new_password']:optional
 * @return int
 * -1:no login
 * -2:no data comes here
 */
require_once("function/function_whulib.php");
require_once("function/function.php");

if(isset($_POST['stunum']))
{
    $res1=is_email($_POST['email'])?change_email($_POST['stunum'],$_POST['email']):-2;
    $res2=is_tel_11($_POST['tel'])?change_tel($_POST['stunum'],$_POST['tel']):-2;
    echo json_encode(array(
        "change_email"=>$res1,
        "change_tel"=>$res2,
    ));
}
else echo json_encode(array(
    "change_email"=>-1,
    "change_tel"=>-1,
));
?>