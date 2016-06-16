
<?php
include('../_includes/application-top.php');
ChecktalentLogin();

include('../_includes/header.php');
include('../_includes/class.database.php');
include('../_includes/class.Profile_pic.php');

$db = new DBClass(db_host, db_username, db_passward, db_name);

$profile_pic = new Profile_pic($_SESSION["talent_id"], "talent");
?>
<style>
    ul.grid.cs-style-3 {
        padding: 0 10px;
    }
    .grid li {
        display: inline-block;
        max-width: 210px;
        margin: 0 0 10px;
        vertical-align: top;
    }
    .grid li a{
        padding: 0 5px;
    }
    .current_profile_pic {
        border-bottom: 1px solid;
        margin: 0 0 20px;
    }
</style>
<?php
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Upload')) {
    if (isset($_FILES['img_path'])) {
        $profile_pic->update($_FILES['img_path'], 1);
    }
}

if (!empty($_REQUEST['photoid']) && $_REQUEST['action'] == "makeprofile") {
    $profile_pic->select_from_gallery($_REQUEST['photoid']);
}

if ((isset($_REQUEST['action'])) AND ( $_REQUEST['action'] == 'delete')) {
    $profile_pic->delete();
}


if (!empty($_REQUEST['photoid']) && ($_REQUEST['action'] == 'delimage')) {
    $profile_pic->delete_by($_REQUEST['photoid']);
}

if (!empty($_REQUEST['uncrop_photoid'])) {
    $profile_pic->uncrop($_REQUEST['uncrop_photoid']);
}
//header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
//header("Expires: Sat, 26 Jul 1997 05:00:00 GMT");
?><div class="content">
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
                    <li>
                        <div class="current_profile_pic">
                            <?php
                            $filename = "../_uploads/user_photo/" . $_SESSION["talent_id"] . ".jpg";
                            if (file_exists($filename)) {
                                ?>
                                <p style="margin: 26px 0 12px;font-size: 14px;font-weight: bold;">Current Profile Photo</p>
                                <a href="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg" class="fancybox">
                                    <img width="100%" height="auto" src="../_uploads/user_photo/<?php echo $_SESSION["talent_id"] ?>.jpg"/>
                                </a>
                                <br>
                                <a href="<?php echo "javascript:Confrim_Delete('update_profile_photo.php?action=delete')"; ?>" title="Delete This Photo">Remove Profile Photo</a>
                                <?php
                            } else {
                                echo '<img width="100%" height="auto" src="../control/images/dummy.png"/>';
                            }
                            ?>
                        </div>
                    </li>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="member.php">Member Area</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="profile_setup.php">Profile Setup</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <a id="exist_photos" href="javascript:showonlyone('newboxes1');" onclick="choose();" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Choose From Photos...</a>
                <a id="upload_new" href="javascript:showonlyone('newboxes2');" onclick="upload()" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Upload Photo...</a>
                <div class="newboxes" id="newboxes1" style="">
                    <p style="margin: 33px 0 0;font-size: 14px;font-weight: bold;">Old Profile Photos:</p>
                    <?php
                    $images_details = $profile_pic->get_gallery();
                    if (!empty($images_details)) {
                        ?>
                        <ul class="grid cs-style-3">
                            <?php
                            foreach ($images_details as $image_detail) {
                                ?>
                                <li>
                                    <a href="<?php echo $image_detail['file_url']; ?>" class="fancybox">
                                        <img src="<?php echo $image_detail['file_url']; ?>" alt=" " width="200" height="200"/>
                                    </a>
                                    <br>
                                    <a href="<?php echo "javascript:Confrim_Profile_Photo('update_profile_photo.php?photoid=" . $image_detail['photo_id'] . "&action=makeprofile')"; ?>">Make Profile Pic</a>
                                    <a href="<?php echo "media_img_cropper.php?photoid=" . $image_detail['photo_id']; ?>">Crop</a>
                                    <?php
                                    if ($image_detail['status'] == 33) {
                                        echo '<a href="update_profile_photo.php?uncrop_photoid=' . $image_detail['photo_id'] . '">Uncrop</a>';
                                    }
                                    ?>
                                    <a href="<?php echo "javascript:Confrim_Photo_Delete('update_profile_photo.php?photoid=" . $image_detail['photo_id'] . "&action=delimage')"; ?>" >Delete</a>

                                </li>
                            <?php }
                            ?>
                        </ul>
                        <?php
                    }
                    ?>
                </div>
                <div class="newboxes" id="newboxes2" style="">
                    <p style="margin: 33px 0 0;font-size: 14px;font-weight: bold;">Upload New Profile Photo:</p>
                    <label style="float: unset;"></label>
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data">
                        <input type="file" name="img_path" value="" /><p>
                            <input type="submit" name="submit" value="Upload" class="button" style="margin: 0 0 0 188px;"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    showonlyone('newboxes1');


    $(document).ready(function () {
        $(".fancybox").fancybox();
    });

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

    function Confrim_Photo_Delete(Url) //confarming property delete
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
            $('#m_profile .current_profile_pic').html('Loading.....');
//            window.location = "" + url;
            $.ajax({
                url: url,
                complete: function (data, text) {
                    $('#m_profile .current_profile_pic').load('update_profile_photo.php #m_profile .current_profile_pic *');
                }
            });
        }
    }

</script> 

<?php
include('../_includes/footer.php');
?>
