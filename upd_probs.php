<?php
/**
 * 更新做题记录
 * @param $_POST['record']=array():neccessary-key:problemid,val:success?
 * @return int
 * -1:no login
 * -2:no data comes here
 */
require_once("function/db_mysqli.php");
function cmp($a,$b)
{
    return $a['problemid']>$b['problemid'];
}
print_r($_POST['record']);
/*
if(is_array($_POST['record'])&&isset($_POST['stunum']))
{
    $pack=$db->getAll("select * from user_problems where stunum='".$_POST['stunum']."'");
    usort($pack,cmp);
    usort($_POST['record'],cmp);
    $l=0;
    $res_ins=array();
    foreach($_POST['record'] as $key=>$val)
    {
        while(isset($pack[$l])&&$pack[$l]['problemid']<$key)$l++;
        if($pack[$l]['problemid']==$key)
            $db->update("user_problems",array(
                "is_right"=>$pack[$l]['is_right']+$val,
                "all_times"=>$pack[$l]['all_times']+1,
            ),"where stunum='".$_POST['stunum']."' and problemid='".$key."'");
        else
            array_push($res_ins,array(
                "stunum"=>$_POST['stunum'],
                "problemid"=>$key,
                "is_right"=>$val,
                "all_times"=>1,
            ));
    }
    $db->insert("user_problems",$res_ins);
    echo 1;
}
else echo -1;*/
?>