<?php

include('../_includes/application-top.php');
CheckLoginForum();

$sql1 = "delete from  tbl_forum_reply where id=" . $_GET['id'] . " ";
mysql_query($sql1);
header("Location:view_forum_topic_admin.php?id=" . $_GET['forum_id'] . "&op=del");
?>