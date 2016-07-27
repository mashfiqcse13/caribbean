<?php

include('../_includes/application-top.php');
ChecktalentLogin();
$query = "DELETE FROM tbl_profile_events WHERE id='" . $_GET['id'] . "'";
$data = mysqli_query($link,$query);
header("location:manage_event.php?op=del");
?>
