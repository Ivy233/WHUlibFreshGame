<?php
/**
 * 更新做题信息
 * @param $_POST=json_encode(
 *            0=>array/object('probid':1,'all_times':2,'right_times')
 *            something like that
 *        )
 * @return array[
 *      0=>array/object('probid':1,'all_times':2,'right_times')
 * ]
 */
$upd_record = json_decode($_POST, true);
if(!empty($upd_record)) {
    require_once("function/db_mysqli.php");
    $db = new DB();
    $res_record=array();
    foreach($upd_record as $record)
    {
        if($record['right_times'] <= $record['all_times']) {
            $problem = $db->getRow("select * from prob_record where year=2019 and probid='".$record['probid']."'");
            if(!empty($problem)) {
                $problem['right_times'] += $record['right_times'];
                $problem['all_times'] += $record['all_times'];
                $db->update("prob_record", $problem, "probid='".$record['probid']."' and year=2019");
            } else {
                $problem = $record;
                $problem['year'] = '2019';
                $db->insert("prob_record", $problem);
            }
            array_push($res_record, array(
                'success' => 1,
                'probid' => $problem['probid'],
                'right_times' => $problem['right_times'],
                'all_times' => $problem['all_times']
            ));
        }
        else array_push($res_record, array(
            'success' => -1,
            'error' => '咋正确次数比作答次数还要多?'
        ));
    }
    echo json_encode($res_record);
}
?>