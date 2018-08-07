<?php
/**
 * 更新做题记录
 * @param $_POST['record']=array():neccessary-key:problemid,val:success?
 * @return int
 * -1:no login
 * -2:no data comes here
 */
function cmp($a,$b)
{
    return $a['problemid']>$b['problemid'];
}
if(isset($_POST['record'])&&isset($_POST['userid']))
{
    $pack=$db->getAll("select * from user_problems where userid='".$_POST['userid']."'");
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
            ),"where userid='".$_POST['userid']."' and problemid='".$key."'");
        else
            array_push($res_ins,array(
                "userid"=>$_POST['userid'],
                "problemid"=>$key,
                "is_right"=>$val,
                "all_times"=>1,
            ));
    }
    $db->insert("user_problems",$res_ins);
}
else if(isset($_POST['userid']))echo -1;
else echo -2;
?>