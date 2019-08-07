<?php
/**
 * 补全电话邮箱
 * @param $_POST['email'] 邮箱
 * @param $_POST['tel'] 电话
 * @param $_POST['stunum'] 学号
 * @return array[
 *      'email': a status,
 *      'tel': a status
 * ]
 * -1: 不知道学号
 * -2:no data comes here
 */
require_once("function/function_whulib.php");
require_once("function/function.php");
require_once("function/db_mysqli.php");
$db = new DB();
if(isset($_POST['stunum']))
{
    if(is_email($_POST['email']))
    {
        $res1 = update_email($_POST['stunum'], $_POST['email']);
        $res1 = $res1['error'];
        $db->update("user_basic", array(
            'email' => $_POST['email'],
        ), "stunum='".$_POST['stunum']."'");
    }
    else $res1 = $_POST['email'] ? $_POST['email'] : -2;
    if(is_tel_11($_POST['tel']))
    {
        $res2 = update_telephone($_POST['stunum'], $_POST['tel']);
        $res2 = $res2['error'];
        $db->update("user_basic", array(
            'tel'=>$_POST['tel'],
        ), "stunum='".$_POST['stunum']."'");
    }
    else $res2 = $_POST['tel'] ? $_POST['tel'] : -2;
    echo json_encode(array(
        "change_email" => $res1, # 如果为空返回-2
        "change_tel" => $res2,   # 如果为空返回-2
    ));
}
else echo json_encode(array(
    "change_email" => -1,
    "change_tel" => -1,
));
?>