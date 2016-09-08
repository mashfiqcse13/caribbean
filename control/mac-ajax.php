<?php

include('include/application_top.php');

include('../_includes/db.inc.php');
$new_mac_req = $_POST['new_mac_req'];
$mac_adr = $_POST['mac_adr'];
$user_id = $_POST['user_id'];
if (isset($new_mac_req) && isset($mac_adr) && isset($user_id)) {
    $sql = "UPDATE `tbl_users` SET `new_mac_req` = $new_mac_req WHERE `id` = $user_id ;
SELECT COUNT(*) INTO @number_of_allowed_mac FROM `tbl_users` WHERE `new_mac_req` = 0 AND `mac_address` = '$mac_adr' ;
UPDATE `tbl_users` SET `allowed_mac`= @number_of_allowed_mac WHERE `mac_address` = '$mac_adr';";
    mysqli_multi_query($link, $sql) or die($sql . "\n Errors : ---------------------\n" . mysqli_error($link));
    echo 'Mac address updated successfully.';
} else {
    echo "error" . print_r($_POST, TRUE);
}