<?php

include('../_includes/application-top.php');
ChecknontalentLogin();
//echo $_SESSION["user_id"];
//exit();
if ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {

    $sql = "DELETE FROM tbl_user_online WHERE uid='" . $_SESSION["user_id"] . "'";

    $query = mysqli_query($link,$sql);

    unset($_SESSION['user_login']);
    $_SESSION['user_login'] = 0;
    $_SESSION['user_id'] = 0;
//session_destroy();
    header("location:login.php");
}
?>
