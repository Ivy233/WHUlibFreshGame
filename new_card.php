<?php
/**
 * 开卡
 * @param 'stunum':string,'success':0/1,'score':int
 * @return POST['success']
 * -1:no login
 * -2:no data comes here
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
if(!empty($_POST['stunum'])&&isset($_POST['success'])&&intval($_POST['score'])){
    $res=array();
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    if($_POST['success']==1){
        if(!$user['new_card_first'])
        {
            $res['new_card_first']=time();
            activate($_POST['stunum']);
        }
        $res['new_card_best']=max($_POST['score'],$user['new_card_best']);
        $res['new_card_way']=$user['new_card_first']?$user['new_card_way']:1;
    }
    $res['new_card_times']=$user['new_card_times']+1;
    $db->update("user_game",$res,"stunum=".$_POST['stunum']);
    echo $_POST['success'];
}
else echo -1;
?>