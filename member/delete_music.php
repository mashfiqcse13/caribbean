<?php

include('../_includes/application-top.php');
ChecknontalentLogin();

/* IMAGE DELETE FUNCTION START HEAR */
$sql = "delete from tbl_profile_music where id='" . $_GET['id'] . "'";
mysql_query($sql);
unlink("../_uploads/profile_music/" . $_GET['id'] . ".mp3");
header("Location:manage_music.php?op=del");
/* IMAGE DELETE FUNCTION END HEAR */
?>
