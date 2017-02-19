<?php
include('include/application_top.php');
cmslogin();
// Check if image file is a actual image or fake image
if (isset($_POST['submit']) && $_POST['submit'] == "Upload Image") {

    $target_file = "../_uploads/admin_avatar/admin_avatar.jpg";
    move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file);
    header("Location:" . BASE_URL . "control/add_admin_avatar.php");
    die();
}


if (isset($_POST['submit']) && $_POST['submit'] == "Remove Image") {
    $filename = "../_uploads/admin_avatar/admin_avatar.jpg";
    if (file_exists($filename)) {
        unlink($filename);
    }
    header("Location:" . BASE_URL . "control/add_admin_avatar.php");
    die();
}
?>
<?php include('include/header.php'); ?>

<?php $image = "../_uploads/admin_avatar/admin_avatar.jpg"; ?>


<style>
    table{
        width: 50%;
        margin: 0 auto;
        padding-top:   100px;
    }
</style>


<h1>Add Fourm Image</h1>

<p style="text-align:right">

    <a href="add-forum-topic-admin.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>

</p>


<form action="" method="post" enctype="multipart/form-data">
    <table>

        <tr>
            <td></td>
            <td>
                <?php
                if (file_exists($image)) {
                    ?>


                    <img src="<?php echo $image . "?" . time(); ?>" height="100" width="100" />

                <?php } else { ?>

                    <img src="../_images/star.png?<?php echo time(); ?>"  height="100" width="100" />


                <?php } ?>

            </td>
        </tr>
        <tr>

            <td><h4>Select image to upload:</h4></td>

            <td><input type="file" name="fileToUpload" id="fileToUpload" required></td>

        </tr>

        <tr>

            <td></td>
            <td><input type="submit" value="Upload Image" name="submit"></td>

        </tr>


    </table>
</form>




<table>

    <tr>

        <td width="235px"></td>

        <td>
            <form action="" method="post" enctype="multipart/form-data">
                <input type="submit" value="Remove Image" name="submit">
            </form>
        </td>

    </tr>

</table>






<?php include('include/footer.php'); ?>