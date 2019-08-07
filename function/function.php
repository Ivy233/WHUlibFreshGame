<?php
function is_email($str)
{
    $res = str_replace(' ', '', $str);
    return preg_match("/\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/", $res);
}
function is_tel_11($str)
{
    $res = str_replace(' ', '', $str);
    return preg_match("/^1[3456789]\d{9}$/", $res);
}
function smkdir($path)
{
	$temp = explode('/', $path);
	$p = '';
	$result = true;
	foreach($temp as $value)
	{
		$p .= $value . '/';
	    if(!is_dir($p)) $result = $result && @mkdir($p);
    }return $result;
}
function fileext($filename)
{
    $stemp = strrchr($filename, ".");
    return substr($stemp, 1);
}
function random($length){
    $source = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
    $len = strlen($source);
    $result = "";
    for($i = 0; $i < $length; $i++) {
        $n = rand(0, $len-1);
        $result .= substr($source, $n, 1);
    }
    return $result;
}
function has_alpha_digit($string)
{
    $flag = 0;
    $length = strlen($string);
    for($i = 0; $i < $length; $i++) {
        if($string[$i] > '0' && $string[$i] < '9')
            $flag |= 1;
        if(($string[$i] > 'a' && $string[$i] < 'z') || ($string[$i] > 'A' && $length[$i] < 'Z'))
            $flag |= 2;
    }
    return $flag;
}
?>