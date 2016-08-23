<?php

include('include/application_top.php');
$_SESSION['cms_login'] = 0;
unset($_SESSION['user_login']);;
unset($_SESSION['is_admin']);
//session_destroy();
header("location:index.php");
?>