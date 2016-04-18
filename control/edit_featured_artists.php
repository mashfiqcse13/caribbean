<?php
include('include/application_top.php');
cmslogin();
$sql = mysql_query("SELECT * FROM  tbl_featured_artists WHERE id='" . $_GET['id'] . "' order by id ");
$result = mysql_fetch_assoc($sql);
//print_r($result);
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update Featured Artists')) {
    if ((isset($_FILES['f_photo']['name'])) && ($_FILES['f_photo']['name'] != '')) {
        $filename = $_FILES['f_photo']['name'];
        $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

        //$file_ext = strrchr($filename, '.');

        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
        } else {
            $data = array(
                "f_artists_name" => mysql_real_escape_string(trim($_POST['f_artists_name'])),
                "status" => $_POST['status']
            );
            $table = "tbl_featured_artists";
            $parameters = "id='" . $_POST["hedden"] . "'";
            updateData($data, $table, $parameters);

            $source_path = $_FILES['f_photo']['tmp_name'];
            $destination = "../_temp/" . $_POST["hedden"] . ".jpg";
            upload_my_file($source_path, $destination);


            /* create thumb upload photo in user_photo folder copy in to temp folder */
            $source = "../_temp/" . $_POST["hedden"] . '.jpg';
            $destination = "../_uploads/featured_artists/" . $_POST["hedden"] . ".jpg";
            //$size=MEMBER_IMAGE_SIZE;
            $size = IMG_SIZE;
            create_thumb($source, $destination, $size);

            /* delete temp folder photo */
            unlink("../_temp/" . $_POST["hedden"] . '.jpg');
            header("Location:featured_artists_manage.php?op=u");
        }
    } else {
        $data = array(
            "f_artists_name" => mysql_real_escape_string(trim($_POST['f_artists_name'])),
            "status" => $_POST['status']
        );
        $table = "tbl_featured_artists";
        $parameters = "id='" . $_POST["hedden"] . "'";
        updateData($data, $table, $parameters);
        header("Location:featured_artists_manage.php?op=u");
    }
}
?>
<?php include('include/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#update_f_artists').validate();
    });
</script>

<?php
if (isset($_GET['op'])) {
    ?>
    <p class="msg">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
            echo "Your Music File upload sucessfully.";
        }
        ?>
    </p>
    <?php
}
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
<h1>EDIT FEATURED ARTISTS</h1>
<p style=""><a href="featured_artists_manage.php" class="button" style="margin:10px 0px 0px 15px; color:#FFFFFF;">Back</a></p>
<div class="add_site_mp3">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="update_f_artists" >
        <input type="hidden" name="hedden" value="<?php echo $result['id']; ?>" />
        <p>
            <label style="width:145px;">Featured Artists Name:</label>
            <input type="text" name="f_artists_name" value="<?php echo $result['f_artists_name']; ?>" class="required">
        </p>
        <p>
            <label style="width:145px;">
                Status:
            </label>
            <select name="status">
                <option <?php
                if ($result["status"] == "1") {
                    echo "selected='selected'";
                }
                ?> value="1">Active</option>
                <option  <?php
                if ($result["status"] == "0") {
                    echo "selected='selected'";
                }
                ?> value="0">Inactive</option>
            </select>
        </p>
        <p>
            <label style="width:145px;">
                Select photo:
            </label>
            <input type="file" name="f_photo"  value="">
        </p>
        <p>
            <input type="submit" name="submit" value="Update Featured Artists" class="button" style="margin-left:150px;">
        </p>
    </form>
</div>           
<?php include('include/footer.php'); ?>
