<?php
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db = new DB();
if(isset($_POST['stunum']))
{
    $user_basic = $db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $user_game = $db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    $subject = "邮件激活-拯救小布的最后一步";
    $token = random(16);
    $body = "
        恭喜同学通过了小布的考验，这一步也是最后一步，只需要点击一个链接即可<br><br>
        <a href = 'http://system.lib.whu.edu.cn/game2018/fresh2019/activate.php?token=$token'>点我激活小布</a><br><br>
        token信息由大小写字母和数字组成，共计16位，如果无法激活可以联系952254420@qq.com<br><br>
    ";
    if(!empty($user_basic['email']) && intval($user_game['new_card_way']) == 0)
    {
        $db->update("user_basic",array(
            "token" => $token,
        ), "stunum = '".$_POST['stunum']."'");
        $to = $user_basic['email'];
        require_once("function/Send_Mail.php");
        Send_Mail($to, $subject, $body);
    } else if(intval($user_game['new_card_way']) != 0)
        echo json_encode(array(
            "success" => -1,
            "error" => "已经激活过了，因此不再发送邮件"
        ));
    else echo json_encode(array(
        "success" => -2,
        "error" => "邮箱不存在"
    ));
} else echo json_encode(array(
    "success" => -3,
    "error" => '学号去哪里了'
));
?>