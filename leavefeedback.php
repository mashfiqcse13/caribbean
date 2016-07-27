<?php

include('_includes/application-top.php');
$oid = $_POST['oid'];
$uid = $_POST['uid'];
$comm = mysqli_real_escape_string( $link ,$_POST['txt']);

$update_comments = mysqli_query($link,"update tbl_orders set buyer_feedback = '$comm' where id = '$oid' and uid='$uid'");

if ($update_comments) {
    echo "1";
}
?>