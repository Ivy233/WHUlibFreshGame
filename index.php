<?php
function cmp($a,$b)
{
    return $a['problemid']>$b['problemid'];
}
$pqr=array(
    array(
        'problemid'=>1,
        'pqr'=>2,
    ),array(
        'problemid'=>3,
        'pqr'=>2,
    ),array(
        'problemid'=>2,
        'pqr'=>2,
    ),array(
        'problemid'=>4,
        'pqr'=>2,
    ),
);
usort($pqr,cmp);
print_r($pqr);
?>