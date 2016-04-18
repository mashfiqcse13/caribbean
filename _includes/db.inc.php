<?php

/* database connection */


//$connt=@mysql_connect('localhost','caribbea_new','c@r!663@9');
$connt = @mysql_connect('localhost', 'root', '');

if (!$connt) {

    echo "datababe connection faild" . mysql_error();
}

/* database selection */

//$selt=mysql_select_db('caribbea_db1',$connt);

$selt = mysql_select_db('caribbea_carabiancirclestar', $connt);

if (!$selt) {

    echo "database selection faild" . mysql_error();
}
?>
                            