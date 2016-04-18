<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Upload')) {
    // $linkcat="../_temp/".$_SESSION["user_id"].'.jpg';
    //@copy($_FILES["img_path"]["tmp_name"],$linkcat);
    $filename = $_FILES['img_path']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    //$file_ext = strrchr($filename, '.');

    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {

        $upload_file = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $_SESSION["user_id"] . ".jpg";
        upload_my_file($upload_file, $destination);

        $source = "../_temp/" . $_SESSION["user_id"] . '.jpg';
        $destination = "../_uploads/user_photo/" . $_SESSION["user_id"] . ".jpg";
        $size = MEMBER_IMAGE_SIZE;
        create_thumb($source, $size, $destination);


        unlink("../_temp/" . $_SESSION["user_id"] . '.jpg');

        /* Added Activity Blow */

        $uname = (GetChatUserName($_SESSION["user_id"]));
        SaveActivity(1, $uname, '', $_SESSION["user_id"]);

        //////////////////////////////////////////////////

        header("Location:member.php?op=up");
    }
}
?>
<?php include('../_includes/header.php'); ?>



<script type="text/javascript">
    $(document).ready(function () {
        $('#upload_image').validate({
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
    <h1>Photo Update</h1>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='err'>" . $MSG . "</p>";
    }
    ?>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START ID m_profile PART -->			
            <div id="m_profile_left"><!--START ID m_profile_left PART -->
                <ul>
                    <li><a href="member.php">Member Area</a></li>
                    <li><a href="change-password.php">Change password</a></li>						
                    <!--<li><a href="upload-image.php">Upload Image</a></li>-->
                    <li><a href="log-out.php">Logout</a></li>
                </ul>

            </div><!--END ID m_profile_left PART -->

            <div id="m_profile_right"><!--START ID m_profile_right PART -->

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="upload_image">
                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/><p>
                        <input type="submit" name="submit" value="Upload" class="button"/>
                </form>

            </div><!--END ID m_profile_right PART -->

        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php include('../_includes/footer.php'); ?>

