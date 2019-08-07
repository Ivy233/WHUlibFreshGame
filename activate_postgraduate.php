<?php
/**
 * 研究生/博士生开卡通道
 * @param $_POST['stunum'] 当前学号
 * @param $_POST['old_stunum'] 之前在武大的学号
 * @return array[
 *      'success' => 状态码
 *      'error' => 'success' <= 0有效，错误信息
 *      'info' => 'success' > 0有效，注意信息
 * ]
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
function check($stunum, $old_stunum)
{
    $user1=bor_info($stunum);
    $user2=bor_info($old_stunum);
    if(!(isset($user1['reader-name']) && isset($user2['reader-name']) && isset($user1['reader-type']) && isset($user2['reader-type']))) return 0;
    if($user1['reader-name'] != $user2['reader-name']) return 0;
    //if(!(is_here($user1) && !is_here($user2)&& !is_active($user1)&& is_active($user2))) return 0;
    if($stunum[4] >= $old_stunum[4])return 0;
    return 1;
}
if(!empty($_POST['stunum']) && !empty($_POST['old_stunum']))
{
    if(check($_POST['stunum'], $_POST['old_stunum']) == 1)
    {
        $db->update("user_basic", array(
            'activate_code' => 2,
        ), "stunum='".$_POST['stunum']."'");
        echo json_encode(array(
            "success" => 1,
            "info" => '邮件没有发送'
        ));
    }
    else echo json_encode(array(
        "success" => 0,
        "error" => '学号不对应'
    ));
}else echo json_encode(array(
    "success" => -1,
    "error" => '缺少东西'
));
?>