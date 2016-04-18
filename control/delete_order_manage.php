<?php

include('include/application_top.php');

$sql = "DELETE FROM  tbl_orders WHERE id='" . $_GET['id'] . "'";
$query = mysql_query($sql);

$sql2 = "DELETE FROM tbl_order_shipping WHERE order_id='" . $_GET['id'] . "'";
$query2 = mysql_query($sql2);

header("Location:order_manage.php?op=del");
?>

