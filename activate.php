<?php
require_once("function/db_mysqli.php");
$db = new DB();
if(isset($_GET['token']) && $_GET['token'])
{
    $user_basic = $db->getRow("select * from user_basic where token ='".$_GET['token']."'");
    if(!empty($user_basic) && $user_basic['activate_times'] == 0)
    {
        activate_freshman($_user_basic['stunum']);
        $db->update("user_basic",array(
            "activate_times" => ($user_basic['activate_times'] + 1)
        ), "stunum = '".$_POST['stunum']."'");
    } else if ($user_basic['activate_times'] > 0) {
        echo "同学你激活过了，所以这次不激活了。";
    } else {
        echo "这次的激活码似乎不太对。";
    }
}
?>