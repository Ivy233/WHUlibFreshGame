<?php
/**
 * 微信绑定
 * @param  $_POST['jscode']:neccessary $_POST['appid']:optional $_POST['secret']:optional
 * @return array ['userid','from='wechat']
 * userid=-2:nothing comes here
 * userid=-1:access denied
 */
if(isset($_POST['jscode'])&&isset($_POST['userid'])){
    require_once("function.php");
    require_once("db_mysqli.php");
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