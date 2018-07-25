<?php
/**
 * 开卡
 * @param nothing neccessary
 * @return int
 * -1:no login
 * -2:no data comes here
 */
session_start();
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_SESSION['userid'])){
    if(isset($_POST['stunum'])&&($_SESSION['stunum'][3]=='2'||$_SESSION['stunum'][4]=='1')){
        $db->update("user_game",array(
            "new_card_first"=>time(),
            "new_card_times"=>1,
        ),"userid='".$_SESSION['userid']."'");
        echo 2;
    }
    else if($_SESSION['stunum'][4]=='3'){
        if(!isset($_POST['success']))echo -2;
        else if($_POST['success']==1){
            $user_game=$db->getRow("select * from user_game where userid='".$_SESSION['userid']."'");
            $res=array();
            if($user_game['new_card_first']==0)
            {
                $res['new_card_first']=time();
                activate($_SESSION['stunum']);
            }
            $res['new_card_times']=$user_game['new_card_times']+1;
            $res['new_card_best']=max($res['new_card_best'],$user_game['new_card_best']);
            $db->update("user_game",$res,"userid=".$_SESSION['userid']);
            echo $_POST['success'];
        }
        else{
            $user_game=$db->getRow("select * from user_game where userid='".$_SESSION['userid']."'");
            $res=array();
            $res['new_card_times']=$user_game['new_card_times']+1;
            $db->update("user_game",$res,"userid=".$_SESSION['userid']);
            echo $_POST['success'];
        }
    }
}
else echo -1;
?>