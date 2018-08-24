<?php
/**
 * 补全电话邮箱
 * @param 'stunum':string,'tel':int(11)(optional),'email':string(@.)(optional)
 * @return array['email':string,'tel':string]
 * -1:no login
 * -2:no data comes here
 */
require_once("function/function_whulib.php");
require_once("function/function.php");
require_once("function/db_mysqli.php");
$db=new DB();
if(isset($_POST['stunum']))
{
    $user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    if(is_email($_POST['email']))
    {
        $res1=change_email($_POST['stunum'],$_POST['email']);
        $db->update("user_basic",array(
            'email'=>$_POST['email'],
        ),"stunum='".$_POST['stunum']."'");
    }
    else $res1=$user['email']?$user['email']:-2;
    if(is_tel_11($_POST['tel']))
    {
        $res2=change_tel($_POST['stunum'],$_POST['tel']);
        $db->update("user_basic",array(
            'tel'=>$_POST['tel'],
        ),"stunum='".$_POST['stunum']."'");
    }
    else $res2=$user['tel']?$user['tel']:-2;
    echo json_encode(array(
        "change_email"=>$res1,
        "change_tel"=>$res2,
    ));
}
else echo json_encode(array(
    "change_email"=>-1,
    "change_tel"=>-1,
));
?>