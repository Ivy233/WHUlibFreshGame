<?php
require_once("../function/db_mysqli.php");
require_once("../function/function_whulib.php");
$db=new DB();
$user=get_info('2018102050005');
print_r($user);
echo (substr($user['z303_delinq'],0,2));
?>