<?php
/**
 * 排行榜
 * @param 'stunum':string
 * @return [{},{},...]
 * -1:no login
 */
require_once("function/db_mysqli.php");
$db=new DB();
if(!empty($_POST['stunum']))
{
    $user['challenge_best']=intval($user['challenge_best']);
    $user['challenge_first']=intval($user['challenge_first']);

    $res_top_100=array();
    $res_nearby=array();

    $top_challenge = $db->getAll("select * from challenge_game where stunum order by challenge_best desc, challenge_time asc, challenge_first asc");
    for($i = 0; $i < 100; $i++) {
        $val = $top_challenge[$i];
        array_push($res_top_100, array(
            "rank" => $i+1,
            "stunum" => $val['stunum'],
            "challenge_best" => $val['challenge_best'],
            "challenge_first" => date("Y-m-d H:i:s", $val['challenge_first']),
            'challenge_time' => $val['challenge_time']
        ));
    }

    $myrank = -1;
    foreach($top_challenge as $key => $val)
        if($val['stunum'] == $_POST['stunum'])
            $myrank = $key;
    if($myrank == -1) $res_nearby = array(-1);
    else {
        for($i = max($myrank - 2, 0); $i < min($myrank + 3, count($top_challenge)); $i++) {
            $val = $top_challenge[$i];
            array_push($res_nearby,array(
                "rank" => $i + 1,
                "stunum" => $val['stunum'],
                "challenge_best" => $val['challenge_best'],
                "challenge_first" => date("Y-m-d H:i:s", $val['challenge_first']),
                'challenge_time' => $val['challenge_time']
            ));
        }
    }
    echo json_encode(array(
        "top100"=>$res_top_100,
        "nearby"=>$res_nearby,
    ));
}else echo json_encode(array(
    "top100"=>array(-1),
    "nearby"=>array(-1),
));
?>