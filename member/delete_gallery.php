<?php

include('../_includes/application-top.php');
/* IMAGE DELETE FUNCTION START HEAR */
$img_location = "../_uploads/profile_photo/" . $_GET['id'] . ".jpg";
if (file_exists($img_location)) {
    @unlink($img_location);
}
$img_location = "../_uploads/profile_photo/thumb/" . $_GET['id'] . ".jpg";
if (file_exists($img_location)) {
    @unlink($img_location);
}
$sql = "DELETE FROM tbl_profile_photos WHERE id='" . $_GET['id'] . "'";
$query = mysql_query($sql);
header("Location:manage_photo.php?op=del");
/* IMAGE DELETE FUNCTION END HEAR */
?>
