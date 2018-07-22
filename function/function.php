<?php
/**
 * 函数库
 * @param nothing
 * @return nothing
 */
date_default_timezone_set('PRC');

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
	foreach($array as $key=>$val)
	{
		$name=$val["name"];
		$value=$val["value"];
		$res[$name]=$value;
	}return $res;
}
function userEnter($stu_num,$arr) {
	$delinq = $arr['z303_delinq'];
	//var_dump($arr);
	if(substr($delinq,0,2)=="04" || substr($delinq,2,2)=="04" || substr($delinq,4,2)=="04" || intval($arr['z305_expiry_date']) < 20170901) {
		if(getVisitInfo() == null)return -2;
		return 1;
	}return -1;
}
function login($stunum,$password) {
	$res = whulib_json_decode(
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
    if(isset($res['error']))return 0;
	return userEnter($stunum,$res);
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
function change_password($stunum,$new_password) {
	$res = whulib_json_decode(
        post("http://system.lib.whu.edu.cn/aleph-x/bor/oper", 
            ['BorForm' => [
				'username'=>'game2018',
                'password'=>'tyl@2018',
                'op'=>'update-bor-password',
                'bor_id'=>$stunum,
                'op_param'=>$new_password,
                'op_param2'=>'',
                'op_param3'=>'']
            ]
        )
    );
//    if(isset($res['error']))
//        return array();
	return $res;
}
print_r(change_password('2017301500308','@WHU20171102'));
?>