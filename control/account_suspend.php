<?php

error_reporting(E_ALL);
include('include/application_top.php');
cmslogin();
ob_start();
$id = $_REQUEST['id'];
$action = $_REQUEST['change_status'];
$note = $_REQUEST['status_note'];
$s_days = trim($_REQUEST['suspend_days']); //Suspend days.
$url_back = trim($_REQUEST['url_back']);
//This is used for Suspend
if ($action == "suspend" && !empty($id) && !empty($s_days)) {
    $suspend_from = date("Y-m-d H:i:s");
    $suspend_to = date("Y-m-d H:i:s", strtotime("$suspend_from +$s_days days"));
    $Query = "UPDATE `tbl_users` SET `suspend_from` = '$suspend_from', `suspend_to` = '$suspend_to' , status_note='" . mysqli_real_escape_string( $link ,$note) . "' ,  `is_block_admin` = 'No' WHERE `id` = '" . mysqli_real_escape_string( $link ,$id) . "';";
    mysqli_query($link,$Query);
    header("location:http://" . $_SERVER['HTTP_HOST'] . "/control/details.php?id=" . $id . "&task=suspend");
}
if ($action == "unsuspend" && !empty($id)) {
    $Query = "UPDATE `tbl_users` SET `suspend_from` = NULL,`suspend_to`=NULL, status_note='' WHERE `id` = '" . mysqli_real_escape_string( $link ,$id) . "';";
    mysqli_query($link,$Query);
    header("location:http://" . $_SERVER['HTTP_HOST'] . "/control/details.php?id=" . $id . "&task=suspend");
}

//This is used for block
if ($action == "block" && !empty($id)) {
    $Query = "UPDATE `tbl_users` SET `is_block_admin` = 'Yes', status_note='" . mysqli_real_escape_string( $link ,$note) . "' ,`suspend_from` = NULL,`suspend_to`=NULL WHERE `id` = '" . mysqli_real_escape_string( $link ,$id) . "';";
    mysqli_query($link,$Query);
    header("location:http://" . $_SERVER['HTTP_HOST'] . "/control/details.php?id=" . $id . "&task=block");
}
//This is used for unblock
if ($action == "unblock" && !empty($id)) {
    $Query = "UPDATE `tbl_users` SET `is_block_admin` = 'No', status_note='' WHERE `id` = '" . mysqli_real_escape_string( $link ,$id) . "';";
    mysqli_query($link,$Query);
    header("location:http://" . $_SERVER['HTTP_HOST'] . "/control/details.php?id=" . $id . "&task=unblock");
}

