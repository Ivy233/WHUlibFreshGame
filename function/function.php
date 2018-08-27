<?php
function is_email($str)
{
    $res=str_replace(' ','',$str);
    return preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/",$res);
}
function is_tel_11($str)
{
    $res=str_replace(' ','',$str);
    return preg_match("/^1[345789]\d{9}$/",$res);
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
?>