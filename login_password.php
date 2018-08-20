<?php
/**
 * 账密登陆
 * @param  $_POST['password']:neccessary
 * @return array ['userid','from='password']
 * userid=-2:nothing comes here
 * userid=-1:access denied
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
if(isset($_POST['stunum'])&&isset($_POST['password'])){
	$success=login($_POST['stunum'],$_POST['password']);
	if($success!=0){
		$user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
		$user_src=get_info($_POST['stunum']);
		if(!isset($user)){
			$db->insert("user_basic",array(
				"stunum"=>$_POST['stunum'],
				"firstlogin"=>time(),
				"name"=>$user_src['reader-name'],
				"academy"=>$user_src['reader-department'],
				"login_times"=>1,
				"email"=>'',
				'tel'=>'',
			));
			$userid=$db->getInsertId();
			$db->insert("user_game",array(
				"stunum"=>$_POST['stunum'],
				"new_card_first"=>0,
				"new_card_times"=>0,
				"new_card_best"=>0,
				"challenge_times"=>0,
				"challenge_best"=>0,
			));
		}
		else 
		{
			$db->update("user_basic",array(
				"login_times"=>$user['login_times']+1,
			),"id='".$user['id']."'");
			$userid=$user['id'];
		}
		echo json_encode(array(
			"userid"=>$userid,
			"stunum"=>$_POST['stunum'],
			"academy"=>$user_src['reader-department'],
			"name"=>$user_src['reader-name'],
			'active'=>(substr($user_src['z303_delinq'],0,2)!="09"),
			'faculty'=>isset($adac_faculty[$user_src['reader-department']])?$adac_faculty[$user_src['reader-department']]:0,
			'time'=>time(),
			"from"=>"password",
		));
	}
	else echo json_encode(array(
		"userid"=>-1,
		"stunum"=>-1,
		"academy"=>-1,
		"name"=>-1,
		'active'=>-1,
		'faculty'=>-1,
		'time'=>time(),
		"from"=>"password",
	));
}
else echo json_encode(array(
	"userid"=>-2,
	"stunum"=>-2,
	"academy"=>-2,
	"name"=>-2,
	'active'=>-2,
	'faculty'=>-2,
	'time'=>time(),
	"from"=>"password",
));
?>