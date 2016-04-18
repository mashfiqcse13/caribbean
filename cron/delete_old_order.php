<?php

include('../_includes/application-top.php');

$del_date = date("Y-m-d", strtotime('-3 month'));

$sql = "SELECT * FROM tbl_orders WHERE order_date <='" . $del_date . "' ";

$sql_query = mysql_query($sql);

//echo $sql_query;


while ($row = mysql_fetch_array($sql_query)) {
    $sql_delete_query = "DELETE FROM tbl_orders WHERE id = '" . $row['id'] . "'";

    $delete_query = mysql_query($sql_delete_query);


    $query_tbl_order_shipping = "DELETE FROM tbl_order_shipping WHERE order_id='" . $row['id'] . "'";

    $delete_tbl_order_shipping = mysql_query($query_tbl_order_shipping);
}
?>