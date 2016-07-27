<?php

session_start();

include('../_includes/db.inc.php');

if (isset($_REQUEST['mac_cntr']) && isset($_REQUEST['mac_adr'])) {
    mysqli_query($link,"UPDATE tbl_users SET allowed_mac=" . $_REQUEST['mac_cntr'] . ",new_mac_req=0 WHERE mac_address='" . $_REQUEST['mac_adr'] . "'");

    echo 'Mac address updated successfully.';
} else {
    echo "error";
}