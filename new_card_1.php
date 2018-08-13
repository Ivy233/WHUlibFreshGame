<?php
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
function check($user1,$user2)
{
    if($user1['reader-name']!=$user2['reader-name'])return 0;
    if($user1['reader-type']!='研究生'||$user2['reader-type']!='本科生')return 0;
    return 1;
}
if(isset($_POST['stunum'])&&isset($_POST['old_stunum'])/*&&$_POST['stunum'][4]=='2'&&$_POST['old_stunum'][4]=='3'*/)
{
    $user1=get_info($_POST['stunum']);
    $user2=get_info($_POST['old_stunum']);
//    print_r($user1);
//    print_r($user2);
    if(check($user1,$user2))
    {
        $this_user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
        $user_game=$db->getRow("select * from user_game where userid='".$this_user['userid']."'");
        $db->update("user_game",array(
            'new_card_first'=>$user_game['new_card_first']?$user_game['new_card_first']:time(),
            'new_card_times'=>$user_game['new_card_times']+1
        ),"userid='".$this_user['userid']."'");
        echo 1;
    }
    else echo 0;
}else echo -1;
?>