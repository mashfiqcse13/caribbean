<?php

include('include/application_top.php');

include('../_includes/db.inc.php');

include_once '../_includes/class.database.php';
$db = new DBClass(db_host, db_username, db_passward, db_name);


$new_mac_req = $_POST['new_mac_req'];
$mac_adr = $_POST['mac_adr'];
$user_id = $_POST['user_id'];
if (isset($new_mac_req) && isset($mac_adr) && isset($user_id)) {
    $sql = "UPDATE `tbl_users` SET `new_mac_req` = $new_mac_req WHERE `id` = $user_id ;
SELECT COUNT(*) INTO @number_of_allowed_mac FROM `tbl_users` WHERE `new_mac_req` = 0 AND `mac_address` = '$mac_adr' ;
UPDATE `tbl_users` SET `allowed_mac`= @number_of_allowed_mac WHERE `mac_address` = '$mac_adr';";
    mysqli_multi_query($link, $sql) or die($sql . "\n Errors : ---------------------\n" . mysqli_error($link));

    $user_details = $db->db_select_as_array('tbl_users', "`id` = $user_id");
    $user_details = $user_details[0];

    if ($user_details['type'] == 1) {
        $login_url = SITE_URL1 . "talents/login.php";
    } else {
        $login_url = SITE_URL1 . "member/login.php";
    }

    $to = $user_details['email'];
    if ($new_mac_req == 1) {
        $subject = "Your account is disabled  | " . SITE_NAME;
        $message = "<h2>Your account is disabled :</h2><hr>We have found that you are using multiple accounts . So , you are disabled . To make a response please login to your account. <a href=\"$login_url\">Click here to login</a>";
    } else {
        $subject = "Your account is enabled  | " . SITE_NAME;
        $message = "<h2>Your account is enabled :</h2><hr>Your multiple accounts issue is sattled . So , you can login to your accout without any restriction . To login to your account. <a href=\"$login_url\">Click here to login</a>";
    }
    $additional_headers = "From: " . FROM_EMAIL . "\r\n";
    // Always set content-type when sending HTML email
    $additional_headers .= "MIME-Version: 1.0" . "\r\n";
    $additional_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($to, $subject, $message, $additional_headers);


    echo 'Mac address updated successfully.';
} else {
    echo "error" . print_r($_POST, TRUE);
}