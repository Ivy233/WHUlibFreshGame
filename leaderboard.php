<?php
/**
 * 排行榜
 * @param $_POST['userid']:necessary
 * @return array(
 *    'name'
 * )
 * -1:no login
 */
session_start();
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_SESSION['userid']))
{
    $res_top_100=array();
    $res_nearby=array();
    $top_100=$db->getAll("select * from user_game order by challenge_best desc, userid asc limit 100");
    $this_user=$db->getRow("select * from user_game where userid='".$_SESSION['userid']."'");
    $myrank=$db->getRow("select count(*) from user_game where challenge_best>".$this_user['challenge_best']." or (challenge_best=".$this_user['challenge_best']." and userid<".$_SESSION['userid'].")");
    $myrank=$myrank['count(*)']+1;
    $prev2=$db->getAll("select * from user_game order by challenge_best asc, userid desc limit 2 where challenge_best>".$this_user['challenge_best']." or (challenge_best=".$this_user['challenge_best']." and userid<".$_SESSION['userid'].")");
    $next2=$db->getAll("select * from user_game order by challenge_best desc, userid asc limit 2 where challenge_best<".$this_user['challenge_best']." or (challenge_best=".$this_user['challenge_best']." and userid>".$_SESSION['userid'].")");
    foreach($top_100 as $key=>$val)
    {
        array_push($res_top_100,array(
            "rank"=>$key+1,
            "userid"=>$val['userid'],
        ));
    }
    foreach($prev2 as $key=>$val)
    {
        array_push($res_nearby,array(
            "rank"=>$myrank-$key-1,
            "userid"=>$val['userid'],
        ));
    }
    array_push($res_nearby,array(
        "rank"=>$myrank,
        "userid"=>$this_user['userid'],
    ));
    foreach($next2 as $key=>$val)
    {
        array_push($res_nearby,array(
            "rank"=>$myrank+$key+1,
            "userid"=>$val['userid'],
        ));
    }
    if($res_nearby[0]['rank']>$res_nearby[1]['rank'])swap($res_nearby[0],$res_nearby[1]);
    echo json_encode(array(
        "top100"=>$res_top_100,
        "nearby"=>$res_nearby,
    ));
}else json_encode(array(
    "top100"=>-1,
    "nearby"=>-1,
));
?>