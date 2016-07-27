<?php

include('../_includes/application-top.php');
CheckLoginForum();

$sql1 = "delete from  tbl_forum_reply where id=" . $_GET['id'] . " ";
mysqli_query($link,$sql1);
header("Location:view_forum_topic_admin.php?id=" . $_GET['forum_id'] . "&op=del");
?>