<?php
require_once("config.php");
function get_openid($wechat){
    if($wechat['appid']&&$wechat['secret']&&$wechat['jscode'])
    {
        $url="https://api.weixin.qq.com/sns/jscode2session?appid=".$wechat['appid']."&secret=".$wechat['secret']."&js_code=".$wechat['jscode']."&grant_type=authorization_code";
        $array=get_object_vars(json_decode(file_get_contents($url)));
        return $array['openid'];
    }else return -1;
}
?>