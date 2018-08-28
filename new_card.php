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
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    if($_POST['success']==1){
        $is_active=is_active(array('z303_delinq'=>$user['tag']));
        if(!$is_active)activate($_POST['stunum']);
        $user_src=get_info($_POST['stunum']);
        $db->update("user_game",array(
            'new_card_times'=>$user['new_card_times']+1,
            'new_card_best'=>max($_POST['score'],$user['new_card_best']),
            'new_card_first'=>$is_active?$user['new_card_first']:time(),
            'new_card_way'=>$is_active?$user['new_card_way']:1,
            'tag'=>$user_src['z303_delinq']
        ),"stunum=".$_POST['stunum']);
    }
    else $db->update("user_game",array(
        'new_card_times'=>$user['new_card_times']+1,
    ),"stunum=".$_POST['stunum']);
    echo $_POST['success'];
}
else echo -1;
?>