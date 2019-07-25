<?php
/*$json = json_encode(array(
    "2" => array('stunum' => '1', 'probid' => 123, 'right' => 1, 'try' => 2),
    "1" => array('stunum' => '2', 'probid' => 125, 'right' => 2, 'try' => 3)
));
print_r($json);*/
/*$decode = json_decode($json);
print_r($decode);
foreach($decode as $key => $value)
{
    print_r($key);
    print_r($value);
}*/
require_once("function/db_mysqli.php");
$db = new DB();
$upd_record = json_decode($_POST);
if(isset($upd_record))
{
    foreach($upd_record as $record)
    {
        if(!isset($upd_record[$record['probid']]))
        {
            $need_update =
            array_push($upd_record,array(

            ));

        }
        //本来用户不需要传过来的，可能需要就多留了
    }
}
?>