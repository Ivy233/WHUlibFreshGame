<?php
/**
 * 登陆
 * @param $_GET['way']='wechat'
 * @param $_POST['jscode'] 微信登陆密钥

 * @param $_GET['way']='pwd'
 * @param $_POST['stunum'] 学号
 * @param $_POST['password'] 加密后的密码
 * @return array[
 *      "success" 成功状态
 *      "stunum" 学号
 *      "academy" 学院
 *      "name" 名字
 *      "active" 是否激活
 *      "plot_score" 开卡模式得分
 *      "pwd_changed" 是否修改密码
 *      "email" 邮箱
 *      "tel" 电话
 *      "login_time" 登陆时间
 *      "way" 登陆方式
 *      "faculty" 学部
 * ]
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db = new DB();
if($_GET['way'] == 'wechat' && !empty($_POST['stunum']))
{
    $user_basic = $db->getRow("select * from user_basic where stunum = '".$_POST['stunum']."'");
    $user_whulib = bor_info($_POST['stunum']);
    $is_activated = is_active($user_whulib);
    if(!isset($user_whulib['error']) && is_here($user_whulib))
    {
        if (empty($user_basic)) {
            $user_basic = array(
                "name" => $user_whulib['reader-name'],
                "academy" => $user_whulib['reader-department'],
                "stunum" => $_POST['stunum'],
                "firstlogin" => time(),
                "pwd_changed" => $is_activated ? 1 : 0,
            );
            $db->insert("user_basic", $user_basic);
            $db->insert("user_game", array(
                "stunum" => $_POST['stunum'],
                "new_card_first" => $is_activated ? time() : 0, //无法确定更早的时间
                "new_card_way" => $is_activated ? 3 : 0,
            ));
        } else $db->update("user_basic", array(
            "login_times" => $user_basic['login_times']+1,
        ), "stunum='".$_POST['stunum']."'");

        $user_game = $db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
        echo json_encode(array(
            "success" => 1,
            "stunum" =>	$user_basic['stunum'],
            "academy" => $user_basic['academy'],
            "name" => $user_basic['name'],
            'active' => $is_activated ? 1 : 0,
            'faculty' => !empty($adac_faculty[$user_basic['academy']]) ? $adac_faculty[$user_basic['academy']] : "???",
            'login_time' => time(),
            'email' => $user_basic['email'],
            'tel' => $user_basic['tel'],
            'plot_score' => $user_game['new_card_best'],
            'pwd_changed' => $user_basic['pwd_changed'],
            'way' => 'password',
        ));
    } else echo json_encode(array(
        'success' => -1,
        'time' => time(),
        "error" => "微信登陆的学号不对",
    ));
} else if($_GET['way'] == 'pwd' && !empty($_POST['stunum']) && !empty($_POST['password'])) {
    $user_whulib = login($_POST['stunum'], $_POST['password']);
    $user_basic = $db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $is_activated = is_active($user_whulib);
    if(!isset($user_whulib['error']) && is_here($user_whulib))
    {
        if(empty($user_basic)){
            $user_basic = array(
                "name" => $user_whulib['reader-name'],
                "academy" => $user_whulib['reader-department'],
                "stunum" => $_POST['stunum'],
                "firstlogin" => time(),
                "pwd_changed" => $is_activated ? 1 : 0,
            );
            $db->insert("user_basic", $user_basic);
            $db->insert("user_game", array(
                "stunum" => $_POST['stunum'],
                "new_card_first" => $is_activated ? time() : 0, //无法确定更早的时间
                "new_card_way" => $is_activated ? 3 : 0
            ));
        } else $db->update("user_basic", array(
            "login_times" => $user_basic['login_times'] + 1
        ), "stunum='".$_POST['stunum']."'");
		$user_game = $db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
		echo json_encode(array(
			"success" => 1,
			"stunum" =>	$user_basic['stunum'],
            "academy" => $user_basic['academy'],
            "name" => $user_basic['name'],
            'active' => $is_activated,
            'faculty' => !empty($adac_faculty[$user_basic['academy']]) ? $adac_faculty[$user_basic['academy']] : 0,
			'login_time' => time(),
			'email' => $user_basic['email'],
			'tel' => $user_basic['tel'],
			'plot_score' => $user_game['new_card_best'],
			'pwd_changed' => $user_basic['pwd_changed'],
            'way' => 'password'
        ));
    } else echo json_encode(array(
        'success' => -2,
        'time' => time(),
        "error" => "学号密码无法对应",
    ));
} else echo json_encode(array(
    'success' => -3,
    'time' => time(),
    "error" => "登陆方式不正确",
));
?>