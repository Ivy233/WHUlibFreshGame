<?php
/**
 * 函数库
 * @param nothing
 * @return nothing
 */

function post($url,$data)
{
	$postdata=http_build_query($data);
	$opts=array('http'=>array(
		'method'=>'POST',
		'header'=>'Content-type: application/x-www-form-urlencoded',
		'content'=>$postdata
	));
	$context=stream_context_create($opts);
	$result=file_get_contents($url, false, $context);
	return $result;
}
function whulib_json_decode($json)
{
	$res = [];
    $array = json_decode($json,TRUE);
    if(is_array($array))
	foreach($array as $val)
	{
		$name=$val["name"];
        $value=$val["value"];
        $res[$name]=$value;
	}return $res;
}
function is_here($user){
    return isset($user['z303_delinq'])&&substr($user['z303_delinq'],0,2)!="04"&&substr($user['z303_delinq'],2,2)!="04"&&substr($user['z303_delinq'],4,2)!="04";
}
function is_active($user){
    return isset($user['z303_delinq'])&&substr($user['z303_delinq'],0,2)!="09";
}
function login($stunum,$password) {
	return whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => 
                ['username'=>'game2018',
                    'password'=>'tyl@2018',
                    'op'=>'bor-auth',
                    'bor_id'=>$stunum,
                    'op_param'=>$password,
                    'op_param2'=>'',
                    'op_param3'=>'']
            ]
        )
    );
}
function get_info($stunum) {
	$res = whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => 
                ['username'=>'game2018',
                    'password'=>'tyl@2018',
                    'op'=>'bor-info',
                    'bor_id'=>$stunum,
                    'op_param'=>'',
                    'op_param2'=>'',
                    'op_param3'=>'']
            ]
        )
    );
    if(isset($res['error']))
        return array();
	return $res;
}
function change_email($stunum,$email) {
	$res = whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => [
				'username'=>'game2018',
                'password'=>'tyl@2018',
                'op'=>'update-bor-email',
                'bor_id'=>$stunum,
                'op_param'=>$email,
                'op_param2'=>'',
                'op_param3'=>'']
            ]
        )
    );
//    if(isset($res['error']))
//        return array();
	return $res;
}
function change_tel($stunum,$tel) {
	$res = whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => [
				'username'=>'game2018',
                'password'=>'tyl@2018',
                'op'=>'update-bor-telephone',
                'bor_id'=>$stunum,
                'op_param'=>$tel,
                'op_param2'=>'',
                'op_param3'=>'']
            ]
        )
    );
//    if(isset($res['error']))
//        return array();
	return $res;
}
function activate($stunum) {
	$res = whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => [
				'username'=>'game2018',
                'password'=>'tyl@2018',
                'op'=>'update-bor-freshman-activate',
                'bor_id'=>$stunum,
                'op_param'=>'',
                'op_param2'=>'',
                'op_param3'=>'']
            ]
        )
    );
//    if(isset($res['error']))
//        return array();
	return $res;
}
?>