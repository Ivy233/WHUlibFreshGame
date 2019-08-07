<?php
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db = new DB();
if(isset($_GET['token']) && $_GET['token'])
{
    $user = $db->getRow("select * from user where token ='".$_GET['token']."'");
    $new_card = $db->getRow("select * from new_card where stunum='".$user['stunum']."'");
    if(!empty($user) && $new_card['new_card_way'] == 0)
    {
        activate_freshman($user['stunum']);
        $db->update("new_card",array(
            "new_card_way" => $user['activate_code'] == 2 ? 2 : 1,
        ), "stunum = '".$user['stunum']."'");
        echo "激活成功";
    } else if ($user['new_card_way'] > 0) {
        echo "已经被激活过了";
    } else {
        echo "激活码似乎不对";
    }
}
?>