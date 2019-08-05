<?php
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db = new DB();
if(isset($_GET['token']) && $_GET['token'] != "")
{
    $user_basic = $db->getRow("select * from user_basic where token ='".$_GET['token']."'");
    if(!empty($user_basic) && $user_basic['activate_times'] == 0)
    {
        activate_freshman($user_basic['stunum']);
        $db->update("user_basic",array(
            "activate_times" => 1
        ), "stunum = '".$user_basic['stunum']."'");
        echo "激活成功";
    } else if ($user_basic['activate_times'] > 0) {
        echo "同学你激活过了，所以这次不激活了。";
    } else {
        echo "这次的激活码似乎不太对。";
    }
}
?>