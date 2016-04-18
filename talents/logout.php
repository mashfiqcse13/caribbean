<?php

include('../_includes/application-top.php');
ChecktalentLogin();

if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
    $sql = "DELETE FROM tbl_user_online WHERE uid='" . $_SESSION["talent_id"] . "'";
    mysql_query($sql);
    unset($_SESSION['talent_id']);
    $_SESSION['talent_login'] = 0;
    $_SESSION['talent_id'] = 0;
//session_destroy();
//$_SESSION['cms_login']=0;
    if (isset($_SESSION['cms_login']) && ($_SESSION['cms_login'] != 0)) {

        unset($_SESSION['user_login']);
    }
    header("location:login.php");
}
?>
