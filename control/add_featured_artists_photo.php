<?php
include('include/application_top.php');
cmslogin();
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Add Featured Artists')) {
    $filename = $_FILES['f_photo']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    //$file_ext = strrchr($filename, '.');

    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {
        $data = array(
            "f_artists_name" => mysql_real_escape_string(trim($_POST['f_artists_name'])),
            "status" => '1'
        );
        insertData($data, "tbl_featured_artists");
        $img_id = mysql_insert_id();

        $source_path = $_FILES['f_photo']['tmp_name'];
        $destination = "../_temp/" . $img_id . ".jpg";
        upload_my_file($source_path, $destination);


        /* create thumb upload photo in user_photo folder copy in to temp folder */
        $source = "../_temp/" . $img_id . '.jpg';
        $destination = "../_uploads/featured_artists/" . $img_id . ".jpg";
        //$size=MEMBER_IMAGE_SIZE;
        $size = IMG_SIZE;
        create_thumb($source, $destination, $size);

        /* delete temp folder photo */
        unlink("../_temp/" . $img_id . '.jpg');
        header("Location:featured_artists_manage.php?op=a");
    }
}
?>
<?php include('include/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_f_artists').validate();
    });
</script>
<?php
if (isset($MSG)) {
    ?>
    <p class="err">
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo $MSG;
        }
        ?>
    </p>
<?php } ?>
<h1>ADD FEATURED ARTISTS</h1>
<p style=""><a href="featured_artists_manage.php" class="button" style=" margin:10px 0px 0px 15px; color:#FFFFFF;">Back</a></p>
<div class="add_site_mp3">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="add_f_artists" >
        <p>
            <label style="width:145px;">Featured Artists Name:</label>
            <input type="text" name="f_artists_name" value="" class="required">
        </p>
        <p>
            <label style="width:145px;">
                Select photo:
            </label>
            <input type="file" name="f_photo" class="required">
        </p>
        <p>
            <input type="submit" name="submit" value="Add Featured Artists" class="button" style="margin-left:150px;">
        </p>
    </form>
</div>           
<?php include('include/footer.php'); ?>
