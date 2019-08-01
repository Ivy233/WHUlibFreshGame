<?php
/**
 * 更新用户成绩
 * @param $_POST['stunum'] 学号
 * @param $_POST['grade'] 成绩
 * @param $_POST['mode'] 是否为挑战模式，1为是，0为否
 * @return array[
 *      "success" 状态码
 *      "stunum" 学号
 *      "can_activate" 能否开卡
 *      "mode" 游戏模式
 * ]
 */
require_once("function/db_mysqli.php");
$db = new DB();
if(isset($_POST['stunum']) && isset($_POST['grade']) && isset($_POST['mode']))
{
    $mode = intval($_POST['mode']);
    $grade = intval($_POST['grade']);
    $stunum = $_POST['stunum'];

    $user_game = $db->getRow("select * from user_game where stunum='".$stunum."'");
    if($mode == 1 && $user_game['new_card_best'] > 60)
    {
        if($grade > $user_game['challenge_best'])
        {
            $user_game['challenge_best'] = $grade;
            $user_game['challenge_first'] = time();
            $user_game['challenge_time'] = intval($_POST['time']);
        }
        $user_game['challenge_times'] = $user_game['challenge_times'] + 1;
        echo (json_encode(array(
            "success" => 1,
            "stunum" => $stunum,
            "can_activate" => 1,
            "mode" => 1
        )));
    } else if($mode == 0){
        if($grade > $user_game['new_card_best'])
            $user_game['new_card_best'] = $grade;
        $user_game['new_card_times'] = $user_game['new_card_times'] + 1;
        echo json_encode(array(
            "success" => 2,
            "stunum" => $stunum,
            "can_activate" => ($grade > 60),
            "mode" => 0
        ));
    } else {
        echo json_encode(array(
            "success" => -1,
            "error" => "你在玩挑战模式并且没有成功开卡"
        ));
        return;
    }
    $db->update("user_game", $user_game, "stunum='".$stunum."'");
} else echo json_encode(array(
    "success" => -2,
    "error" => "缺少信息"
));
?>