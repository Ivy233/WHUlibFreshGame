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
function check($user1,$user2)
{
    if(!(isset($user1['reader-name'])&&isset($user2['reader-name'])&&$user1['reader-name']==$user2['reader-name']))return 0;
    if(!(isset($user1['reader-type'])&&isset($user2['reader-type'])&&intval(strpos("$".$user1['reader-type'],'硕士生'))&&intval(strpos("$".$user2['reader-type'],'本科生'))))return 0;
    return 1;
}
$_POST=array(
    'stunum'=>'2017301500308',
    'old_stunum'=>'2017301500308'
);
if(isset($_POST['stunum'])&&isset($_POST['old_stunum'])/*&&$_POST['stunum'][4]=='2'&&$_POST['old_stunum'][4]=='3'*/)
{
    $user1=get_info($_POST['stunum']);
    $user2=get_info($_POST['old_stunum']);
    print_r($user1);
    print_r($user2);
    echo check($user1,$user2);
}else echo -1;
?>