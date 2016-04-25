<?php

/* database connection */


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
                            