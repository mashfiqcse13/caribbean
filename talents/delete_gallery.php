<?php

include('../_includes/application-top.php');
/* IMAGE DELETE FUNCTION START HEAR */

if ((isset($_GET['id'])) && ($_GET['id'] != '')) {

    if ($_GET['pid'] != 0) {

        $img_location = "../_uploads/profile_photo/" . $_GET['id'] . ".jpg";
        if (file_exists($img_location)) {
            @unlink($img_location);
        }
        $img_location = "../_uploads/profile_photo/thumb/" . $_GET['id'] . ".jpg";
        if (file_exists($img_location)) {
            @unlink($img_location);
        }

        $sql = "DELETE FROM tbl_profile_photos WHERE id='" . $_GET['id'] . "'";
        $query = mysqli_query($link,$sql);

        $sql1 = "delete from tbl_products where id='" . $_GET['pid'] . "'";
        mysqli_query($link,$sql1);



        unlink("../_uploads/profile_product/" . $_GET['pid'] . ".jpg");
        unlink("../_uploads/profile_product/thumb/" . $_GET['pid'] . ".jpg");
        header("Location:manage_photo.php?op=del");
    }


    $img_location = "../_uploads/profile_photo/" . $_GET['id'] . ".jpg";
    if (file_exists($img_location)) {
        @unlink($img_location);
    }
    $img_location = "../_uploads/profile_photo/thumb/" . $_GET['id'] . ".jpg";
    if (file_exists($img_location)) {
        @unlink($img_location);
    }
    $sql = "DELETE FROM tbl_profile_photos WHERE id='" . $_GET['id'] . "'";
    $query = mysqli_query($link,$sql);
    header("Location:manage_photo.php?op=del");
}
/* IMAGE DELETE FUNCTION END HEAR */
?>
