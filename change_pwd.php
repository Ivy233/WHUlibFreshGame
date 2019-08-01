<?php
/**
 * 修改密码
 * @param $_POST['stunum'] 学号
 * @param $_POST['old_pwd'] 老密码
 * @param $_POST['new_pwd'] 新密码
 * @return array[
 *      'success': 修改密码成功状态码
 *      'error': 只有出现异常才会输出
 * ]
 */
if(isset($_POST['stunum']) && isset($_POST['old_pwd']) && isset($_POST['new_pwd'])) {
    require_once("function/db_mysqli.php");
    $db = new DB();
    require_once("function/function_whulib.php");
    require_once("function/function.php");
    $user_whulib = login($_POST['stunum'], $_POST['old_pwd']);
    if(isset($user_whulib['error'])) {
        echo json_encode(array(
            "success" => -1,
            "error" => "原密码不对"
        ));
    } else if($_POST['old_pwd'] == $_POST['new_pwd']){
        echo json_encode(array(
            "success" => -2,
            "error" => "新老密码完全一样"
        ));
    } else if(strlen($_POST['new_pwd']) < 8 || strlen($_POST['new_pwd']) > 16) {
        echo json_encode(array(
            "success" => -4,
            "error" => "新密码长度大于16位或者小于8位"
        ));
    } else if(has_alpha_digit($_POST['new_pwd']) != 3) {
        echo json_encode(array(
            "success" => -3,
            "error" => "新密码包含非法字符"
        ));
    } else {
        update_password($_POST['stunum'], $_POST['new_pwd']); #
        $db->update("user_basic", array(
            "pwd_change" => 1
        ), "stunum='".$_POST['stunum']."'");
        echo json_encode(array(
            "success" => 1,
        ));
    }
}
?>