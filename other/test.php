<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$users=$db->getAll("select * from user_game where new_card_best>100");
foreach($users as $user){
}
?>