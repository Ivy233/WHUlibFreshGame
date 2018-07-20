<?php
/**
 * 微信登陆
 * @param  $_POST['jscode']:neccessary $_POST['appid']:optional $_POST['secret']:optional
 * @return array ['userid','from='wechat']
 * userid=-2:nothing comes here
 * userid=-1:access denied
 */
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
		echo json_encode(array(
			"userid"=>$user['id'],
			"from"=>"weixin",
		));
	}else echo json_encode(array(
		"userid"=>-1,
		"from"=>"weixin",
	));
}
else echo json_encode(array(
	"userid"=>-2,
	"from"=>"weixin",
));
?>