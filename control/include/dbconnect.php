<?php
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
$connection = @mysql_connect($db_host, $db_username, $db_passward) or die('error');
//1.Create database Connection
if (!$connection) {
    die("database connection faild:" . mysql_error());
}
//2.select a database to use
$db_select = mysql_select_db($db_name, $connection);
if (!$db_select) {
    die("database selection faild:" . mysql_error());
}
?>

