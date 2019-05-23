<?php
/**
 * 账密登陆
 * @param  'stunum':string,'password':string;
 * @return array [
 *    "stunum":POST['stunum'],
 *    "academy":string,
 *	  "name":string,
 *	  'active':0/1,
 *	  'faculty':0/1/2/3,
 *	  'time'=>time(),
 *	  "from"=>"password",]
 */
require_once("function/db_mysqli.php");
require_once("function/function_whulib.php");
$db=new DB();
if(!empty($_POST['stunum'])&&!empty($_POST['password'])){
	$user_src=login($_POST['stunum'],$_POST['password']);
	if(!isset($user_src['error'])&&is_here($user_src)){
		$is_active=is_active($user_src);
		$user=$db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
		if(!isset($user)){
			$db->insert("user_basic",array(
				"stunum"=>$_POST['stunum'],
				"firstlogin"=>time(),
				"name"=>$user_src['reader-name'],
				"academy"=>$user_src['reader-department'],
				"login_times"=>1,
			));
			$db->insert("user_game",array(
				"stunum"=>$_POST['stunum'],
				"new_card_first"=>$is_active?time():0,
				"new_card_way"=>$is_active?3:0,
				"tag"=>$user_src['z303_delinq'],
			));
		}
		else 
		{
			$db->update("user_basic",array(
				"login_times"=>$user['login_times']+1,
			),"stunum='".$_POST['stunum']."'");
			$db->update("user_game",array(
				"tag"=>$user_src['z303_delinq'],
			),"stunum='".$_POST['stunum']."'");
		}
		echo json_encode(array(
			"stunum"=>$_POST['stunum'],
			"academy"=>$user_src['reader-department'],
			"name"=>$user_src['reader-name'],
			'active'=>$is_active,
			'faculty'=>!empty($adac_faculty[$user_src['reader-department']])?$adac_faculty[$user_src['reader-department']]:0,
			'time'=>time(),
			"from"=>"password",
		));
	}
	else echo json_encode(array(
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
	"stunum"=>-2,
	"academy"=>-2,
	"name"=>-2,
	'active'=>-2,
	'faculty'=>-2,
	'time'=>time(),
	"from"=>"password",
));
?>