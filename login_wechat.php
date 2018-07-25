<?php
/**
 * 微信登陆
 * @param  $_POST['jscode']:neccessary $_POST['appid']:neccessary $_POST['secret']:neccessary
 * @return array ['userid','from='wechat']
 * userid=-2:nothing comes here
 * userid=-1:access denied
 */
session_start();
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db=new DB();
if(isset($_POST['jscode'])&&isset($_POST['secret'])){
	$openid=get_openid($_POST);
	$user=$db->getRow("select * from user where openid='".$openid."'");
	if(!empty($user)&&$openid){
		$db->update("user_basic",array(
			"login_times"=>$user['login_times']+1,
		),"id='".$user['id']."'");
		$_SESSION=array(
			"userid"=>$user['id'],
			"stunum"=>$user['stunum'],
			"time"=>time(),
		);
		
		echo json_encode(array(
			"userid"=>$user['id'],
			"from"=>"wechat",
		));
	}else echo json_encode(array(
		"userid"=>-1,
		"from"=>"wechat",
	));
}
else echo json_encode(array(
	"userid"=>-2,
	"from"=>"wechat",
));
?>