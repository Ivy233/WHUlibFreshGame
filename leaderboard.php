<?php
/**
 * 排行榜
 * @param nothing
 * @return array(
 *    'name'
 * )
 * -1:no login
 */
require_once("function/db_mysqli.php");
$db=new DB();
$_POST['stunum']='2017301500308';
if(isset($_POST['stunum']))
{
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    
    $res_top_100=array();
    $res_nearby=array();
    $top_100=$db->getAll("select * from user_game order by challenge_best desc, challenge_first asc limit 100");
    $myrank=$db->getRow("select count(*) from user_game where challenge_best>".$user['challenge_best']." or (challenge_best=".$user['challenge_best']." and challenge_first<".$user['challenge_first'].")");
    $myrank=$myrank['count(*)']+1;
    $prev2=$db->getAll("select * from user_game where (challenge_best>".$user['challenge_best']." or ( challenge_best=".$user['challenge_best']." and challenge_first<".$user['challenge_first']." )) order by challenge_best asc, challenge_first desc limit 2");
    $next2=$db->getAll("select * from user_game where (challenge_best<".$user['challenge_best']." or ( challenge_best=".$user['challenge_best']." and challenge_first>".$user['challenge_first']." )) order by challenge_best desc, challenge_first asc limit 2");
    
    foreach($top_100 as $key=>$val)
    {
        array_push($res_top_100,array(
            "rank"=>$key+1,
            "stunum"=>$val['stunum'],
            "challenge_best"=>$val['challenge_best'],
            "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first'])
        ));
    }
    foreach($prev2 as $key=>$val)
    {
        array_push($res_nearby,array(
            "rank"=>$myrank-$key-1,
            "stunum"=>$val['stunum'],
            "challenge_best"=>$val['challenge_best'],
            "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first'])
        ));
    }
    array_push($res_nearby,array(
        "rank"=>$myrank,
        "stunum"=>$user['stunum'],
        "challenge_best"=>$user['challenge_best'],
        "challenge_first"=>date("Y-m-d H:i:s",$user['challenge_first'])
    ));
    foreach($next2 as $key=>$val)
    {
        array_push($res_nearby,array(
            "rank"=>$myrank+$key+1,
            "stunum"=>$val['stunum'],
            "challenge_best"=>$val['challenge_best'],
            "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first'])
        ));
    }
    if($res_nearby[0]['rank']>$res_nearby[1]['rank'])swap($res_nearby[0],$res_nearby[1]);
    echo json_encode(array(
        "top100"=>$res_top_100,
        "nearby"=>$res_nearby,
    ));
}else echo json_encode(array(
    "top100"=>-1,
    "nearby"=>-1,
));
?>