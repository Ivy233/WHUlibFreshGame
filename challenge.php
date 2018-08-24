<?php
/**
 * 挑战模式更新
 * @param 'stunum':string,'best':int
 * @return 1
 * -1:no login
 */
require_once("function/db_mysqli.php");
$db=new DB();
if(isset($_POST['stunum'])&&intval($_POST['best']))
{
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    $db->update("user_game",array(
        'challenge_times'=>$user['challenge_times']+1,
        'challenge_best'=>max($_POST['best'],$user['challenge_best']),
        'challenge_first'=>$_POST['best']>$user['challenge_best']?time():$user['challenge_first'],
        'challenge_time'=>$_POST['best']>$user['challenge_best']?$_POST['time']:$user['challenge_time']
    ),"stunum=".$_POST['stunum']);
    echo 1;
}
else echo -1;
?>