<?php

include('include/application_top.php');
$_SESSION['cms_login'] = 0;
unset($_SESSION['user_login']);;
unset($_SESSION['is_admin']);
unset($_SESSION['user_id']);
unset($_SESSION['talent_login']);
unset($_SESSION['talent_id']);
//session_destroy();
header("location:index.php");
?>