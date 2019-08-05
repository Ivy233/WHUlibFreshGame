<?php
function Send_Mail($to,$subject,$body)
{
require 'class.phpmailer.php';
$from       = "xiaobu@notify.lib.whu.edu.cn";
$mail       = new PHPMailer();
$mail->IsSMTP(true);            // use SMTP
$mail->IsHTML(true);
$mail->SMTPAuth   = true;
$mail->Host       = "tls://msg.lib.whu.edu.cn";
$mail->Port       =  465;                    // set the SMTP port
$mail->Username   = "xiaobu@notify.lib.whu.edu.cn";  // SMTP  username
$mail->Password   = "rWL#5pTYn9k";  // SMTP password
$mail->SetFrom($from, 'From Name');
$mail->AddReplyTo($from,'From Name');
$mail->Subject    = $subject;
$mail->MsgHTML($body);
$address = $to;
$mail->AddAddress($address, $to);
$mail->Send();
}
?>
