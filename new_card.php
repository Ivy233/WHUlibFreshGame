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
    $user_src=get_info($_POST['stunum']);
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    $db->update("user_game",array(
        'new_card_times'=>$user['new_card_times']+1,
        'new_card_best'=>$_POST['success']?max($_POST['score'],$user['new_card_best']):$user['new_card_best'],
        'new_card_first'=>$_POST['success']&&!is_active($user_src)?time():$user['new_card_first'],
        'new_card_way'=>$_POST['success']&&$user['new_card_way']==0?1:$user['new_card_way']
    ),"stunum=".$_POST['stunum']);
    activate($_POST['stunum']);
    $user_src=get_info($_POST['stunum']);
    $db->update("user_basic",array(
        'tag'=>$user_src['z303_delinq']
    ),"where stunum='".$_POST['stunum']."'");
    echo $_POST['success'];
}
else echo -1;
?>