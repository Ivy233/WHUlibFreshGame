<?php
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db = new DB();
if(isset($_GET['token']) && $_GET['token'] != "")
{
    $user_basic = $db->getRow("select * from user_basic where token ='".$_GET['token']."'");
    if(!empty($user_basic) && $user_basic['activate_times'] == 0)
    {
        activate_freshman($user_basic['stunum']);
        $db->update("user_basic",array(
            "activate_times" => 1
        ), "stunum = '".$user_basic['stunum']."'");
        echo "����ɹ�";
    } else if ($user_basic['activate_times'] > 0) {
        echo "ͬѧ�㼤����ˣ�������β������ˡ�";
    } else {
        echo "��εļ������ƺ���̫�ԡ�";
    }
}
?>