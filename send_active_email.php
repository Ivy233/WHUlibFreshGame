<?php
require_once("function/db_mysqli.php");
require_once("function/function.php");
$db = new DB();
$_POST['stunum'] = '2017301500308';
if(isset($_POST['stunum']))
{
    $user_basic = $db->getRow("select * from user_basic where stunum='".$_POST['stunum']."'");
    $subject = "�ʼ��������С�������һ��";
    $token = random(16);
    /*$body = "
        �����人��ѧͼ��ݵ�С������Ϣ��<br><br>
        ͬѧ�����ã����������������ʼ���˵�����Ѿ�ͨ��������С���������޸�����ϵ�绰����������䡣<br><br>
        ����һ����֤�ʼ�����������������Լ���ͼ��ݽ���Ȩ�ޡ�<br><br>
        <a href = 'http://system.lib.whu.edu.cn/game2018/fresh2019/activate.php?token=$token'>���Ҽ��</a><br><br>
        ����������֮������ֻ��ʹ�õ�ַ����token��Ϣ���˺Ž���ƥ�䣬����ͼ��ݷ��ͼ�����Ϣ��
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