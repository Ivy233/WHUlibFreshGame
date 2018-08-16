<?php
    $ret = array(  
    'name' => isset($_POST['name'])? $_POST['name'] : '',  
    'gender' => isset($_POST['gender'])? $_POST['gender'] : ''  
    );  
    header('content-type:application:json;charset=utf8');  
    header('Access-Control-Allow-Origin:*');  
    header('Access-Control-Allow-Methods:POST');  
    header('Access-Control-Allow-Headers:x-requested-with,content-type');  
    echo json_encode($ret);  
?>