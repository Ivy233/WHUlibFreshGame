<?php
/**
 * 账密登陆
 * @param  'stunum':string;
 * @return int
 * -1:no login
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
if(!empty($_POST['stunum'])){
    $user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $tmp=$db->getAll("select user_basic.id from user_game,user_basic where user_game.tag='000000' and user_game.stunum=user_basic.stunum and user_basic.academy='".$user['academy']."'");
    echo count($tmp);
}
else echo -1;
?>