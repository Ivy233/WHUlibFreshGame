<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$users=$db->getAll("select * from user_basic where stunum like '2018_________'");
foreach($users as $user){
    $new_user=$db->getRow("select * from user_game where new_card_first>='".$user['firstlogin']."' and new_card_first<='".($user['firstlogin']+5)."' and stunum='".$user['stunum']."'");
    if(isset($new_user))
    {
        $user['firstlogin']-=$new_user['new_card_first'];
        print_r($user);
    }
}
?>