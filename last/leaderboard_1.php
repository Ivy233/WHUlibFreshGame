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
    $user=$db->getRow("select * from user_game where stunum='".$_POST['stunum']."'");
    $user['challenge_best']=intval($user['challenge_best']);
    $user['challenge_first']=intval($user['challenge_first']);
     
    $res_top_100=array();
    $res_nearby=array();
    $top_100=$db->getAll("select * from user_game 
                        where stunum like '2018_________' 
                        and challenge_best>0 
                        order by challenge_best desc, challenge_first asc limit 100");
    foreach($top_100 as $key=>$val)
    {
        array_push($res_top_100,array(
            "rank"=>$key+1,
            "stunum"=>$val['stunum'],
            "challenge_best"=>$val['challenge_best'],
            "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first']),
            'challenge_time'=>$val['challenge_time']
        ));
    }

    $myrank=$db->getRow("select count(*) from user_game 
                        where stunum like '2018_________' and 
                        (challenge_best>".$user['challenge_best']." 
                        or (challenge_best=".$user['challenge_best']." 
                        and challenge_first<".$user['challenge_first']."))");
    $myrank=$myrank['count(*)']+1;
    $prev2=$db->getAll("select * from user_game 
                        where stunum like '2018_________' 
                        and (challenge_best>".$user['challenge_best']." 
                        or (challenge_best=".$user['challenge_best']." 
                        and challenge_first<".$user['challenge_first']." )) 
                        order by challenge_best asc, challenge_first desc 
                        limit 1");
    $next2=$db->getAll("select * from user_game 
                        where stunum like '2018_________' and
                        (challenge_best<".$user['challenge_best']." 
                        or (challenge_best=".$user['challenge_best']." 
                        and challenge_first>".$user['challenge_first']." )) 
                        order by challenge_best desc, challenge_first asc 
                        limit 1");
    if(substr($_POST['stunum'],0,4)=='2018'){
        foreach($prev2 as $key=>$val)
        {
            array_push($res_nearby,array(
                "rank"=>$myrank-$key-1,
                "stunum"=>$val['stunum'],
                "challenge_best"=>$val['challenge_best'],
                "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first']),
                'challenge_time'=>$val['challenge_time']
            ));
        }
        array_push($res_nearby,array(
            "rank"=>$myrank,
            "stunum"=>$user['stunum'],
            "challenge_best"=>$user['challenge_best'],
            "challenge_first"=>date("Y-m-d H:i:s",$user['challenge_first']),
            'challenge_time'=>$user['challenge_time']
        ));
        foreach($next2 as $key=>$val)
        {
            array_push($res_nearby,array(
                "rank"=>$myrank+$key+1,
                "stunum"=>$val['stunum'],
                "challenge_best"=>$val['challenge_best'],
                "challenge_first"=>date("Y-m-d H:i:s",$val['challenge_first']),
                'challenge_time'=>$val['challenge_time']
            ));
        }
    }
    else $res_nearby=array(-1);
    echo json_encode(array(
        "top100"=>$res_top_100,
        "nearby"=>$res_nearby,
    ));
}else echo json_encode(array(
    "top100"=>array(-1),
    "nearby"=>array(-1),
));
?>