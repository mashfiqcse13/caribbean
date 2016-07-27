<?php

include('_includes/application-top.php');
CheckLoginForum();
$sql = "delete from tbl_forum_topics where id=" . $_GET['id'] . " ";
mysqli_query($link,$sql);
$sql1 = "delete from  tbl_forum_reply where forum_id=" . $_GET['id'] . " ";
mysqli_query($link,$sql1);
header("Location:forum.php?op=d");
//echo $_GET['id'];
?>