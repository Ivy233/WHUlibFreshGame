<?php
/**
 * 挑战模式更新
 * @param $_POST['success']:neccessary
 * @return int
 * -1:no login
 */
session_start();
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_POST['userid']))
{
    $user_game=$db->getRow("select * from user_game where userid='".$_POST['userid']."'");
    $res=array();
    $res['challenge_times']=$user['challenge_times']+1;
    if($_POST['success']==1)$res['challenge_best']=max($res['new_card_best'],$user_game['challenge_best']);
    $db->update("user_game",$res,"userid=".$_POST['userid']);
    echo $_POST['success'];
}
else echo -1;
?>