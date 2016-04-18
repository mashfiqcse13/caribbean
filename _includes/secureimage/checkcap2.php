<?php

header('HTTP/1.1 200 OK');
session_start();
require 'securimage2.php';
$securimage = new Securimage();
if ($securimage->check($_REQUEST['captcha_code']) == false)
    echo 'false';
else
    echo 'true';
?>