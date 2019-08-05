<?php
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db = new DB();
$_POST['stunum'] = '2017301500308';
if(isset($_POST['stunum']))
{
    $user_basic = $db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $subject = "邮件激活：拯救小布的最后一步";
    $token = random(16);
    /*$body = "
        来自武汉大学图书馆的小布的信息：<br><br>
        同学，您好！如果您看到了这封邮件，说明您已经通过了拯救小布，并且修改了联系电话、密码和邮箱。<br><br>
        这是一封验证邮件，请点击下面的链接以激活图书馆进入权限。<br><br>
        <a href = 'http://system.lib.whu.edu.cn/game2018/fresh2019/activate.php?token=$token'>点我激活！</a><br><br>
        点击这个链接之后，我们只会使用地址栏的token信息与账号进行匹配，并向图书馆发送激活信息。
    ";*/
    $body = "123456";
    if(!empty($user_basic))
    {
        $db->update("user_basic",array(
            "token" => $token,
            "activate_times" => 0
        ), "stunum = '".$_POST['stunum']."'");
        $to = $user_basic['email'];
        require_once("function/smtp/Send_Mail.php");
        Send_Mail($to, $subject, $body);
        print_r($to);
        print_r($subject);
        print_r($body);
    }
}
?>