<?php

/* database connection */


if ($_SERVER['HTTP_HOST'] == 'gill.mashfiqnahid.com') {
    $db_username = 'thejamun_gill';
    $db_passward = 'I5Qsid,b&2Sr';
    $db_name = 'thejamun_mashfiq_gill';
    $db_host = 'localhost';
} else if ($_SERVER['HTTP_HOST'] == 'mashfiq.caribbeancirclestars.com') {
    $db_username = 'caribbea_new';
    $db_passward = 'c@r!663@9';
    $db_name = 'caribbea_new';
    $db_host = 'localhost';
} else {
    $db_username = 'root';
    $db_passward = '';
    $db_name = 'caribbea_carabiancirclestar';
    $db_host = 'localhost';
}
$connt = @mysql_connect($db_host, $db_username, $db_passward);

if (!$connt) {

    echo "datababe connection faild" . mysql_error();
}

/* database selection */

//$selt=mysql_select_db('caribbea_db1',$connt);

$selt = mysql_select_db($db_name, $connt);

if (!$selt) {

    echo "database selection faild" . mysql_error();
}
?>
                            