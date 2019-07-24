<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$users=$db->getAll("select * from user_game limit 1800,300");
foreach($users as $user)
{
    $user_src=get_info($user['stunum']);
    $db->update("user_game",array(
        'tag'=>$user_src['z303_delinq']
    ),"stunum='".$user['stunum']."'");
}
?>