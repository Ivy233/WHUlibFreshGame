<?php
/**
 * 开卡
 * @param 'stunum':string,'old_stunum':string like 'stunum'
 * @return POST['success']
 * -1:no login
 * -2:no data comes here
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
function check($stunum,$old_stunum)
{
    $user1=get_info($stunum);
    $user2=get_info($old_stunum);
    if(!(isset($user1['reader-name'])&&isset($user2['reader-name'])&&isset($user1['reader-type'])&&isset($user2['reader-type'])))return 0;
    if($user1['reader-name']!=$user2['reader-name'])return 0;
//    if(!(is_here($user1)&&!is_here($user2)&&!is_active($user1)&&is_active($user2)))return 0;
    if($stunum[4]>=$old_stunum[4])return 0;
    return 1;
}
if(!empty($_POST['stunum'])&&!empty($_POST['old_stunum']))
{
    if(check($_POST['stunum'],$_POST['old_stunum']))
    {
        $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
        $is_active=is_active(array('z303_delinq'=>$user['tag']));
        if(!$is_active)activate($_POST['stunum']);
        $user_src=get_info($_POST['stunum']);
        $db->update("user_game",array(
            'new_card_first'=>$is_active?$user['new_card_first']:time(),
            'new_card_times'=>$user['new_card_times']+1,
            'new_card_way'=>$is_active?$user['new_card_way']:2,
            'tag'=>$user_src['z303_delinq'],
        ),"stunum='".$_POST['stunum']."'");
        echo 1;
    }
    else echo 0;
}else echo -1;
?>