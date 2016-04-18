<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'update')) {

    /* USER IMAGE UPLOAD */
    if ((isset($_FILES['img_path']['name'])) && ($_FILES['img_path']['name'] != '')) {
        $filename = $_FILES['img_path']['name'];
        $file_ext = strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload ".jpg",".jpeg",".gif",".png" only!';
        } else {
            $data = array(
                "user_id" => $_SESSION["talent_id"],
                "photo_title" => mysql_real_escape_string(trim($_POST['photo_title'])),
                "photo_details" => mysql_real_escape_string(trim($_POST['photo_details'])),
                "status" => '1'
            );
            $table = "tbl_profile_photos";
            $parameters = "id='" . $_GET['id'] . "'";
            updateData($data, $table, $parameters);

            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $_GET['id'] . ".jpg";
            upload_my_file($upload_file, $destination);

            /* $source="../_temp/".$_GET['id'].'.jpg';
              $destination="../_uploads/profile_photo/thumb/".$_GET['id'].".jpg";
              $size=PROFILE_PHOTO_THUMB;
              create_thumb($source,$destination,$size); */

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $dest = "../_uploads/profile_photo/thumb/" . $_GET['id'] . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $destination = "../_uploads/profile_photo/" . $_GET['id'] . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);

            /* $source="../_temp/".$_GET['id'].'.jpg';
              $dest="../_uploads/profile_photo/".$_GET['id'].".jpg";
              CreateFixedSizedImage($source,$dest,$width=600,$height=600); */

            unlink("../_temp/" . $_GET['id'] . '.jpg');

            header("Location:manage_photo.php?op=u");
        }
    } else {
        $data = array(
            "user_id" => $_SESSION["talent_id"],
            "photo_title" => mysql_real_escape_string(trim($_POST['photo_title'])),
            "photo_details" => mysql_real_escape_string(trim($_POST['photo_details'])),
            "status" => '1'
        );
        $table = "tbl_profile_photos";
        $parameters = "id='" . $_GET['id'] . "'";
        updateData($data, $table, $parameters);

        header("Location:manage_photo.php?op=u");
    }
}
?>
<?php include('../_includes/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#img_update').validate({
            rules: {
                img_path: {
                    /*required: true,*/
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Upadte Image</h1>
    <p style="text-align:right"><a href="manage_photo.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <?php /* ?>	<div id="m_profile_left"><!--START CLASS m_profile_left PART -->
              <ul>
              <li><a href="add_profile_details.php">Profile Details</a></li>
              <li><a href="manage_photo.php">Manage Photo</a></li>
              <li><a href="manage_music.php">Manage Music</a></li>
              <li><a href="manage_video.php">Manage Video</a></li>
              </ul>
              </div><!--END CLASS m_profile_left PART --><?php */ ?>


            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <?php
                $result = mysql_query("SELECT * FROM tbl_profile_photos WHERE id='" . $_GET['id'] . "' ");
                ?>

                <?php
                while ($row = mysql_fetch_assoc($result)) {
                    ?>
                    <form action="update_gallery.php?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="img_update">
                        <p><label for="photo_title">Title</label>
                            <input type="text" name="photo_title" value="<?php echo $row['photo_title'] ?>" class="required" maxlength="100"/> 
                        </p>
                        <p><label style="vertical-align:top;" for="photo_details">Details</label>
                            <textarea name="photo_details" id="details" class="required" style="height:100px; width:300px;" maxlength="255"><?php echo $row['photo_details']; ?></textarea>
                        </p>
                        <!--///////CHECK THE IMAGE IS ALREADY EXITS OR NOT////////-->	
                        <?php
                        $img_path = "../_uploads/profile_photo/thumb/" . $row['id'] . ".jpg";
                        if (file_exists($img_path)) {
                            ?>
                            <?php /* ?><p style="margin-left:140px;"><img src="<?php echo $img_path; ?>"/></p><?php */ ?>
                            <p style="margin-left:140px;"><a href="../_uploads/profile_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="<?php echo $img_path; ?>" alt="Image"/></a></p>
                            <?php
                        }
                        ?>

                        <p>
                            <label>Select Photo:</label>
                            <input type="file" name="img_path" />
                        </p>
                        <input type="submit" name="submit" value="update" class="button" />
                    </form>
                    <?php
                }
                ?>
            </div><!--END ID m_profile_right PART -->
        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php include('../_includes/footer.php'); ?>



