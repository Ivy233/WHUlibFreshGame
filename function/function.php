<?php
function is_email($str)
{
    $res=str_replace(' ','',$str);
    return preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$res);
}
function is_tel_11($str)
{
    $res=str_replace(' ','',$str);
    return preg_match("/^1[3456789]\d{9}$/",$res);
}
function smkdir($path)
{
	$temp=explode('/',$path);
	$p='';
	$result=true;
	foreach($temp as $value)
	{
		$p.=$value.'/';
	    if(!is_dir($p)) $result=$result&&@mkdir($p);
    }return $result;
}
function fileext($filename)
{
    $stemp=strrchr($filename,".");
    return substr($stemp,1);
}
function random($length){
    $source="0123456789abcdefghijklmnopqrstuvwxyz";
    $len=strlen($source);
    $result="";
    for($i=0;$i<$length;$i++){
        $n=rand(0,$len-1);
        $result.=substr($source,$n,1);
    }
    return $result;
}
function get_openid($weixin){
    if(!isset($weixin['appid']))$weixin['appid']="wx890f194b0e74ddc0";
    if(!isset($weixin['secret']))$weixin['secret']="d95bb0210b7a2663917592c1b59c15dc";
    if(isset($weixin['appid'])&&isset($weixin['secret'])&&isset($weixin['jscode']))
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$weixin['appid']."&secret=".$weixin['secret']."&js_code=".$weixin['jscode']."&grant_type=authorization_code";
        $array=get_object_vars(json_decode(file_get_contents($url)));
        return $array['openid'];
    }else return -1;
}
?>