<?php

include('../_includes/application-top.php');
ChecktalentLogin();



/* IMAGE DELETE FUNCTION START HEAR */
if ((isset($_GET['id'])) && ($_GET['id'] != '')) {

    if ($_GET['pid'] != 0) {

        $sql1 = "delete from tbl_products where id='" . $_GET['pid'] . "'";
        mysqli_query($link,$sql1);

        $sql = "delete from tbl_profile_music where id='" . $_GET['id'] . "'";
        mysqli_query($link,$sql);
        unlink("../_uploads/profile_music/" . $_GET['id'] . ".mp3");
        header("Location:manage_music.php?op=del");
    }

    $sql = "delete from tbl_profile_music where id='" . $_GET['id'] . "'";
    mysqli_query($link,$sql);
    unlink("../_uploads/profile_music/" . $_GET['id'] . ".mp3");
    header("Location:manage_music.php?op=del");
}
/* IMAGE DELETE FUNCTION END HEAR */
?>
