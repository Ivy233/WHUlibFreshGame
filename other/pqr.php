<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$users=$db->getAll("select * from user_game limit 100");
for($i=0;$i<100;$i++)
{
    $user=$users[$i];
    $user_src=get_info($user['stunum']);
    if(!is_active($user_src)&&($user['new_card_first']||$user['challenge_first'])){
        print_r($user);
    }
}
?>