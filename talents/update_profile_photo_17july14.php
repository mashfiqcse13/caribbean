<?php
include('../_includes/application-top.php');
ChecktalentLogin();

include('../_includes/header.php');

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

        $MSG = 'Your Profile Photo has been updated Successfully!';

        header("Location:update_profile_photo.php");
    }
}

if (!empty($_REQUEST['photoid']) && $_REQUEST['action'] == "makeprofile") {

    $file = "../_uploads/profile_photo/thumb/" . $_REQUEST['photoid'] . ".jpg";
    $newfile = "../_uploads/user_photo/" . $_REQUEST['photoid'] . ".jpg";
    $newfile1 = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
    copy($file, $newfile);
    unlink("../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg");
    rename($newfile, $newfile1);
    $MSG = 'Your Profile Photo has been updated Successfully!';
    //header("Location:update_profile_photo.php");
}

if ((isset($_REQUEST['action'])) AND ( $_REQUEST['action'] == 'delete')) {
    unlink("../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg");
    $MSG = 'Your Profile Photo has been deleted Successfully!';
    //header("Location:update_profile_photo.php");
}
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }

    function showonlyone(thechosenone) {
        $('.newboxes').each(function (index) {
            if ($(this).attr("id") == thechosenone) {
                $(this).show(200);
            } else {
                $(this).hide(600);
            }
        });
    }

    function Confrim_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Photo ?"))
        {
            window.location = "" + Url;
            return false;
        }
    }

    function Confrim_Profile_Photo(url) //confarming property delete
    {
        if (confirm("Are you sure you want to make this Profile Photo ?"))
        {
            window.location = "" + url;
        }
    }

</script> 
<div class="content">
    <h1>Update profile photo</h1>
    <!-- <p style="text-align:right"><a href="javascript:void(0)" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p> -->
    <?php
    if (isset($MSG)) {
        ?>
        <p class="msg">
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
                    <a id="exist_photos" href="javascript:showonlyone('newboxes1');" onclick="choose();" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Choose From Photos...</a>
                    <a id="upload_new" href="javascript:showonlyone('newboxes2');" onclick="upload()" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Upload Photo...</a>
                    <div class="newboxes" id="newboxes1" style="border: 1px solid black; background-color: #CCCCCC; display: none;padding: 7px; width: 98%;position: relative;top: 8px;">
                        <p style="">Current Profile Photo:</p>
                        <?php $filename = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg"; ?>

                        <?php if (file_exists($filename)) { ?>
                            <div style="">
                                <img width="120" height="150" src="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg"/>
                            </div>
                            <a style="float: right;margin: -100px 635px 0 0;" href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>"><img src="../_images/del.png" title="Delete This Photo"></a>
                        <?php } else { ?>
                            <div style="">
                                <img width="120" height="150" src="../control/images/dummy.png"/>
                            </div>
                        <?php } ?>   

                    </div>
                    <div class="newboxes" id="newboxes2" style="border: 1px solid black; background-color: #CCCCCC; display: none;padding: 7px; width: 98%;position: relative;top: 8px;">Current Profile Photo:
                        <?php if (file_exists($filename)) { ?>
                            <div style="">
                                <img width="120" height="150" src="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg"/>
                            </div>
                            <a style="float: right;margin: -100px 635px 0 0;" href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>"><img src="../_images/del.png" title="Delete This Photo"></a>
                        <?php } else { ?>
                            <div style="">
                                <img width="120" height="150" src="../control/images/dummy.png"/>
                            </div>
                        <?php } ?>
                        <p><label style="float: unset;">Upload New Profile Photo:</label><input type="file" name="img_path" value="" /><p>
                            <input type="submit" name="submit" value="Update" class="button" style="margin: 0 0 0 188px;"/>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php
include('../_includes/footer.php');
?>
