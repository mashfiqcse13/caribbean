<?php

include('../_includes/application-top.php');

$sql = "DELETE FROM  tbl_msg WHERE id='" . $_GET['id'] . "'";
$query = mysqli_query($link,$sql);

header("Location:view_message.php?op=del");
?> 
