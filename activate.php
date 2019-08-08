<?php
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db = new DB();
if(isset($_GET['token']) && $_GET['token'])
{
    $user_basic = $db->getRow("select * from user_basic where token ='".$_GET['token']."'");
    $user_game = $db->getRow("select * from user_game where stunum='".$user_basic['stunum']."'");
    if(!empty($user_basic) && $user_game['new_card_way'] == 0)
    {
        activate_freshman($user_basic['stunum']);
        $db->update("user_game",array(
            "new_card_way" => $user_basic['activate_code'] == 2 ? 2 : 1,
        ), "stunum = '".$user_basic['stunum']."'");
        echo "激活成功";
    } else if ($user_basic['new_card_way'] > 0) {
        echo "这个账号已经激活过了";
    } else {
        echo "激活码似乎不对";
    }
}
?>