<?php
/**
 * 微信绑定
 * @param  $_POST['jscode']:neccessary $_POST['appid']:neccessary $_POST['secret']:neccessary
 * @return array ['userid','from='bind']
 * userid=-2:nothing comes here
 * userid=-1:access denied
 */
if(isset($_POST['jscode'])&&isset($_POST['userid'])){
    require_once("function/function_wechat.php");
    require_once("function/db_mysqli.php");
    $openid=get_openid($_POST);
    $db=new DB();
    $user=$db->getRow("select * from user where id='".$_POST['userid']."'");
    if(!empty($user)){
        $db->update("user",array(
            "openid"=>$openid,
        ),"id='".$_POST['userid']."'");
        echo json_encode(array(
            'userid'=>$user['stuid'],
            'from'=>'bind',
        ));
    }else echo json_encode(array(
        'userid'=>-1,
        'from'=>'bind',
    ));
}else echo json_encode(array(
    'userid'=>-2,
    'from'=>'bind',
));
?>