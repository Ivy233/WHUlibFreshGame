<?php
if(isset($_POST['BorForm']['op']))
{
    if($_POST['BorForm']['op']=='challenge')
    {
        $_POST=array(
            'stunum'=>$_POST['BorForm']['bor_id'],
            'best'=>$_POST['BorForm']['op_param']
        );
        $url='../challenge.php';
    }else if($_POST['BorForm']['op']=='newcard')
    {
        $_POST=array(
            'stunum'=>$_POST['BorForm']['bor_id'],
            'success'=>$_POST['BorForm']['op_param'],
            'score'=>$_POST['BorForm']['op_param2']
        );
        $url='../new_card.php';
    }else if($_POST['BorForm']['op']=='newcard1')
    {
        $_POST=array(
            'stunum'=>$_POST['BorForm']['bor_id'],
            'old_stunum'=>$_POST['BorForm']['op_param'],
        );
        $url='../new_card_1.php';
    }
    require_once($url);
}else echo -1;
?>