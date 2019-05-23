<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$users=$db->getAll("select  * from user_game where new_card_best!=0 and tag like '09____'");
foreach($users as $user){
    activate($user['stunum']);
    $user_src=get_info($user['stunum']);
    $db->update("user_game",array(
        'new_card_first'=>time(),
        "new_card_way"=>1,
        'tag'=>$user_src['z303_delinq']
    ),"stunum='".$user['stunum']."'");
}
?>