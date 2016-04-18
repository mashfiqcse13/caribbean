<?php
include('../_includes/application-top.php');

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Image')) {


    /* USER IMAGE UPLOAD */
    $filename = $_FILES['img_path']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    //$file_ext = strrchr($filename, '.');

    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {
        $data = array(
            "user_id" => $_SESSION['user_id'],
            "photo_title" => mysql_real_escape_string(trim($_POST['photo_title'])),
            "photo_details" => mysql_real_escape_string(trim($_POST['photo_details'])),
            "status" => '1'
        );
        insertData($data, "tbl_profile_photos");


        $img_id = mysql_insert_id();

        $upload_file = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $img_id . ".jpg";
        upload_my_file($upload_file, $destination);

        /* $source="../_temp/".$img_id.'.jpg';
          $destination="../_uploads/profile_photo/thumb/".$img_id.".jpg";
          $size=PROFILE_PHOTO_THUMB;
          create_thumb($source,$destination,$size); */

        $source = "../_temp/" . $img_id . '.jpg';

        $dest = "../_uploads/profile_photo/thumb/" . $img_id . ".jpg";
        CreateFixedSizedImage($source, $dest, $width = 150, $height = 150);

        $destination = "../_uploads/profile_photo/" . $img_id . ".jpg";
        $size = PROFILE_PHOTO_BIG;
        create_thumb($source, $size, $destination);

        /* $source="../_temp/".$img_id.'.jpg';
          $dest="../_uploads/profile_photo/".$img_id.".jpg";
          CreateFixedSizedImage($source,$dest,$width=600,$height=600); */

        unlink("../_temp/" . $img_id . '.jpg');

        /* Added Activity Blow */

        $uname = (GetChatUserName($_SESSION["user_id"]));
        SaveActivity(2, $uname, '', $_SESSION["user_id"]);

        //////////////////////////////////////////////////

        header("Location:manage_photo.php?op=a");
    }
}

ChecknontalentLogin();
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#img_upload').validate({
            rules: {
                img_path: {
                    required: true,
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Add Image</h1>
    <p style="text-align:right"><a href="manage_photo.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='err'>" . $MSG . "</p>";
        }
        ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <?php /* ?><div id="m_profile_left"><!--START CLASS m_profile_left PART -->
              <ul>
              <li><a href="add_profile_details.php">Profile Details</a></li>
              <li><a href="manage_photo.php">Manage Photo</a></li>
              <li><a href="manage_music.php">Manage Music</a></li>
              <li><a href="manage_video.php">Manage Video</a></li>
              </ul>
              </div><!--END CLASS m_profile_left PART --><?php */ ?>

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <!--/////USER IMAGE UPLOAD/////-->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="img_upload" enctype="multipart/form-data">
                    <p><label for="photo_title">Title</label>
                        <input type="text" name="photo_title" value="" class="required" maxlength="100"/> 
                    </p>
                    <p><label style="vertical-align:top;" for="photo_details">Details</label>
                        <textarea name="photo_details" id="details" style="height:100px; width:300px;" maxlength="255"></textarea>
                    </p>				
                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/></p>

                    <input type="submit" name="submit" value="Add Image" class="button"/>
                </form>
            </div><!--END CLASS m_profile_right PART -->
        </div><!--END CLASS m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
