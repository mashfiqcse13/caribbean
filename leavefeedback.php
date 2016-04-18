<?php

include('_includes/application-top.php');
$oid = $_POST['oid'];
$uid = $_POST['uid'];
$comm = mysql_real_escape_string($_POST['txt']);

$update_comments = mysql_query("update tbl_orders set buyer_feedback = '$comm' where id = '$oid' and uid='$uid'");

if ($update_comments) {
    echo "1";
}
?>