<?php

header('HTTP/1.1 200 OK');
session_start();
require 'securimage.php';
$securimage = new Securimage();
$securimage_code_value = $_SESSION['securimage_code_value'];
$securimage_code_ctime = $_SESSION['securimage_code_ctime'];
//echo $securimage_code_ctime.$securimage_code_value;
$result = false;
if ($securimage->check($_REQUEST['captcha_code']) == false) {
    $result = 'false';
} else {
    $result = 'true';
}
$_SESSION['securimage_code_value'] = $securimage_code_value;
$_SESSION['securimage_code_ctime'] = $securimage_code_ctime;
echo $result;
?>