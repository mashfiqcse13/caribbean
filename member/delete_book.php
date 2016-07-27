<?php

include('../_includes/application-top.php');
ChecknontalentLogin();
/* IMAGE DELETE FUNCTION START HEAR */
$img_location = "../_uploads/profile_book_photo/" . $_GET['id'] . ".jpg";
if (file_exists($img_location)) {
    @unlink($img_location);
}
$img_location = "../_uploads/profile_book_photo/thumb/" . $_GET['id'] . ".jpg";
if (file_exists($img_location)) {
    @unlink($img_location);
}
$sql = "DELETE FROM tbl_profile_books WHERE id='" . $_GET['id'] . "'";
$query = mysqli_query($link,$sql);
header("Location:manage_book.php?op=del");
/* IMAGE DELETE FUNCTION END HEAR */
?>
