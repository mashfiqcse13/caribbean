<?php

include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_GET['id'])) && ($_GET['id'] != '')) {

    if ($_GET['pid'] != 0) {

        $img_location = "../_uploads/profile_book_photo/" . $_GET['id'] . ".jpg";
        if (file_exists($img_location)) {
            @unlink($img_location);
        }
        $img_location = "../_uploads/profile_book_photo/thumb/" . $_GET['id'] . ".jpg";
        if (file_exists($img_location)) {
            @unlink($img_location);
        }
        $sql = "DELETE FROM tbl_profile_books WHERE id='" . $_GET['id'] . "'";
        $query = mysql_query($sql);

        /* PRODUCT IMAGE DELETE FUNCTION START HEAR */
        $sql1 = "delete from tbl_products where id='" . $_GET['pid'] . "'";
        mysql_query($sql1);



        unlink("../_uploads/profile_product/" . $_GET['pid'] . ".jpg");
        unlink("../_uploads/profile_product/thumb/" . $_GET['pid'] . ".jpg");

        header("Location:manage_book.php?op=del");
    }


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
    $query = mysql_query($sql);
    header("Location:manage_book.php?op=del");
}
/* IMAGE DELETE FUNCTION END HEAR */
?>
