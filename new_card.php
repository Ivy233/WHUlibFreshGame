<?php
/**
 * 开卡
 * @param nothing neccessary
 * @return int
 * -1:no login
 * -2:no data comes here
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
if(isset($_POST['stunum'])&&isset($_POST['success'])&&intval($_POST['score'])){
    $res=array();
    $this_user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $user_game=$db->getRow("select * from user_game where userid='".$this_user['userid']."'");
    if($_POST['success']==1){
        if(!$user_game['new_card_first'])
        {
            $res['new_card_first']=time();
            activate($_POST['stunum']);
        }
        $res['new_card_best']=max($_POST['best_score'],$user_game['new_card_best']);
    }
    $res['new_card_times']=$user_game['new_card_times']+1;
    $db->update("user_game",$res,"stunum=".$_POST['stunum']);
    echo $_POST['success'];
}
else echo -1;
?>