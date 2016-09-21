<?php

include('include/application_top.php');

include('../_includes/db.inc.php');

include_once '../_includes/class.database.php';
$db = new DBClass(db_host, db_username, db_passward, db_name);
if (!empty($_POST['banned_user_id']) && !empty($_POST['mac_msg_by_admin'])) {
    $banned_user_id = $_POST['banned_user_id'];
    $data_to_insert = array(
        "mac_msg_by_admin" => $_POST['mac_msg_by_admin']
    );
    $db->db_update('tbl_users', $data_to_insert, "`id` = $banned_user_id");


    $banned_user_details = $db->db_select_as_array('tbl_users', "`id` = $banned_user_id");
    $banned_user_details = $banned_user_details[0];

    if ($banned_user_details['type'] == 1) {
        $login_url = SITE_URL1 . "talents/login.php";
    } else {
        $login_url = SITE_URL1 . "member/login.php";
    }

    $to = $banned_user_details['email'];
    $subject = "About your disabled account | " . SITE_NAME;
    $message = "<h2>Admin says :</h2><hr>{$_POST['mac_msg_by_admin']}<br><hr>Note : To make a response please login to your account. <a href=\"$login_url\">Click here to login</a>";
    $additional_headers = "From: " . FROM_EMAIL . "\r\n";
    // Always set content-type when sending HTML email
    $additional_headers .= "MIME-Version: 1.0" . "\r\n";
    $additional_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    mail($to, $subject, $message, $additional_headers);

    header("Location: " . SITE_URL . "details.php?id=$banned_user_id");
    die();
}