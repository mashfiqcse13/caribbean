<?php

$connection = @mysql_connect("localhost", 'root', '') or die('error');
//1.Create database Connection
if (!$connection) {
    die("database connection faild:" . mysql_error());
}
//2.select a database to use
$db_select = mysql_select_db("caribbea_carabiancirclestar", $connection);
if (!$db_select) {
    die("database selection faild:" . mysql_error());
}
?>

