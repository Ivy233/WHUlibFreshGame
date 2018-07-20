<?php
/**
 * 开卡
 * @param $_POST['userid']:necessary $_POST['stunum']:necessary
 * @param if stunum is '201axxxxxxxxx',a<=4:
 *          $_POST['score']:necessary,$_POST['time']:necessary,$_POST['success']:neccessary
 * @return int
 * -2:nothing comes here
 */
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_POST['stunum'])&&isset($_POST['userid']))
{
    if(ismaster($_POST['stunum'])){
        $db->update("user_game",array(
            "new_card_first"=>time(),
            "new_card_times"=>1,
        ),"userid='".$_POST['userid']."'");
        echo 1;
    }else if($_POST['success']==1){
        $user_game=$db->getRow("select * from user_game where userid='".$_POST['userid']."'");
        $res=array();
        if($user_game['new_card_first']==0)$res['new_card_first']=time();
        $res['new_card_times']=$user['new_card_times']+1;
        $res['new_card_best']=max($res['new_card_best'],$user_game['new_card_best']);
        $db->update("user_game",$res,"userid=".$_POST['userid']);
        echo 2;
    }else{
        $user_game=$db->getRow("select * from user_game where userid='".$_POST['userid']."'");
        $res=array();
        $res['new_card_times']=$user['new_card_times']+1;
        $db->update("user_game",$res,"userid=".$_POST['userid']);
        echo 3;
    }
}
else echo -2;
?>