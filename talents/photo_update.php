<?php
include('../_includes/application-top.php');
ChecktalentLogin();

if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update')) {
    /* move upload photo in temp folder */
    //get the file ext:
    $filename = $_FILES['img_path']['name'];
    $file_ext = ".".pathinfo($filename,PATHINFO_EXTENSION);

    //$file_ext = strrchr($filename, '.');
    //check if its allowed or not:
    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload images only!';
    } else {

        /* $linkcat="../_temp/".$_SESSION["talent_id"].'.jpg';
          @copy($_FILES["img_path"]["tmp_name"],$linkcat); */

        $source_path = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $_SESSION["talent_id"] . ".jpg";
        upload_my_file($source_path, $destination);

        /* create thumb upload photo in user_photo folder copy in to temp folder */
        $source = "../_temp/" . $_SESSION["talent_id"] . '.jpg';
        $destination = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
        $size = MEMBER_IMAGE_SIZE;
        create_thumb($source, $size, $destination);

        /* delete temp folder photo */
        unlink("../_temp/" . $_SESSION["talent_id"] . '.jpg');

        /* Added Activity Blow */
        $uname = (GetChatUserName($_SESSION["talent_id"]));
        SaveActivity(1, $uname, '', $_SESSION["talent_id"]);

        header("Location:member.php?op=u");
    }
}

include('../_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script> 
<div class="content">
    <h1>Photo Update</h1>
    <p style="text-align:right"><a href="javascript:void(0)" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p>
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
    <div class="form_class">
        <div id="m_profile">
            <div id="m_profile_left">
                <ul>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="profile_setup.php">Profile Setup</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" /><p>
                        <input type="submit" name="submit" value="Update" class="button" />
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('../_includes/footer.php');
?>
