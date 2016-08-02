<?php
include('../_includes/application-top.php');
ChecknontalentLogin();


include('../_includes/class.Profile_pic.php');

$db = new DBClass(db_host, db_username, db_passward, db_name);

$profile_pic = new Profile_pic($_SESSION["user_id"], "talent");

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
include('../_includes/header.php');
?>

<style>
    ul.grid.cs-style-3 {
        padding: 0 10px;
    }
    .grid li {
        display: inline-block;
        width: 210px;
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
                    <li>
                        <div class="current_profile_pic">
                            <?php
                            $filename = "../_uploads/user_photo/" . $_SESSION["user_id"] . ".jpg";
                            if (file_exists($filename)) {
                                ?>
                                <p style="margin: 26px 0 12px;font-size: 14px;font-weight: bold;">Current Profile Photo</p>
                                <a href="<?php echo "$filename?" . time() ?>" class="fancybox">
                                    <img width="100%" height="auto" src="<?php echo "$filename?" . time() ?>"/>
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
                    <li><a href="member.php<?php echo $user_idd; ?>">Member Area</a></li>
                    <li><a href="change-password.php<?php echo $user_idd; ?>">Change password</a></li>
                    <li><a href="log-out.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <a id="exist_photos" href="javascript:showonlyone('newboxes1');" onclick="choose();" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Choose From Photos...</a>
                <a id="upload_new" href="javascript:showonlyone('newboxes2');" onclick="upload()" style="background-color: #ccc; padding: 0px 0px 0px 0px;">Upload Photo...</a>
                <script> var photo_id_of_prfile_pic = 0;</script>
                <div class="newboxes" id="newboxes1" style="">
                    <p style="margin: 33px 0 0;font-size: 14px;font-weight: bold;">Old Profile Photos:</p>
                    <?php
                    $images_details = $profile_pic->get_gallery();
                    if (!empty($images_details)) {
                        ?>
                        <ul class="grid cs-style-3">
                            <?php
                            foreach ($images_details as $image_detail) {
                                if ($image_detail['is_profile_picture'] == 2) {
                                    ?> <script>photo_id_of_prfile_pic = <?php echo $image_detail['photo_id'] ?>;</script>
                                <?php } ?>
                                <li id="item_no_<?php echo $image_detail['photo_id'] ?>">
                                    <a href="<?php echo $image_detail['file_url']; ?>" class="fancybox">
                                        <img src="<?php echo $image_detail['file_url'] . "?" . time(); ?>" alt=" " width="200" height="200"/>
                                    </a>
                                    <br>
                                    <?php
                                    echo '<a href="javascript:Confrim_Profile_Photo(\'update_profile_photo.php?photoid=' . $image_detail['photo_id'] . $user_idd1 . '&action=makeprofile\',' . $image_detail['photo_id'] . ')">Make Profile Pic</a>';
                                    echo '<a href="javascript:crop_img(\'media_img_cropper.php?photoid=' . $image_detail['photo_id'] . $user_idd1 . '\',' . $image_detail['photo_id'] . ')">Crop</a>';
                                    if ($image_detail['status'] == 33) {
                                        echo '<a href="javascript:uncrop_img(\'update_profile_photo.php?uncrop_photoid=' . $image_detail['photo_id'] . $user_idd1 . '\',' . $image_detail['photo_id'] . ')">Uncrop</a>';
                                    }
                                    ?>
                                    <a href="<?php echo "javascript:Confrim_Photo_Delete('update_profile_photo.php?photoid=" . $image_detail['photo_id'] . "$user_idd1&action=delimage',{$image_detail['photo_id'] })"; ?>" >Delete</a>

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
                    <form id="ajax_form" action="update_profile_photo.php" method="post" enctype="multipart/form-data">
                        <input type="hidden" name='id' value="<?php echo $_SESSION['user_id'] ?>"/>
                        <input type="file" name="img_path" value="" /><p>
                            <input type="submit" name="submit" value="Upload" class="button" style="margin: 0 0 0 188px;"/>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../_script/jquery.form.min.js" type="text/javascript"></script>
<script type="text/javascript">
                                        showonlyone('newboxes1');
                                        $(document).ready(function () {
                                            $(".fancybox").fancybox();
                                            $('#ajax_form').ajaxForm({
                                                dataType: 'json',
                                                beforeSubmit: function (responseText, statusText) {
                                                    $('body').html('Loading........');
                                                },
                                                success: function (responseText, statusText) {
                                                    if (responseText.destination_url != null) {
                                                        $('body').load(responseText.destination_url);
                                                    } else {
                                                        alert("Failed to upload");
                                                        $('body').load('update_profile_photo.php');
                                                    }
                                                }
                                            });
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
                                                var target_selector_to_update = '#m_profile .current_profile_pic';
                                                $(target_selector_to_update).html('Loading.....');
                                                $.ajax({
                                                    url: Url,
                                                    complete: function (data, text) {
                                                        $(target_selector_to_update).load('update_profile_photo.php ' + target_selector_to_update + ' *');
                                                    }
                                                });
                                                //deleting the profile pic form the gallary
                                                delete_photo_from_the_gallary('update_profile_photo.php?photoid=' + photo_id_of_prfile_pic + '&id=19&action=delimage', photo_id_of_prfile_pic);
                                            }
                                        }

                                        function delete_photo_from_the_gallary(Url, photo_id) {
                                            var target_selector_to_update = '#item_no_' + photo_id;
                                            $.ajax({
                                                url: Url,
                                                complete: function (data, text) {
                                                    $(target_selector_to_update).fadeOut(1000);
                                                    $('#m_profile .current_profile_pic').load('update_profile_photo.php #m_profile .current_profile_pic *');
                                                }
                                            });
                                        }
                                        function Confrim_Photo_Delete(Url, photo_id) //confarming property delete
                                        {
                                            if (confirm("Are you sure you want to delete this Photo ?"))
                                            {
                                                delete_photo_from_the_gallary(Url, photo_id);
                                            }
                                        }

                                        function uncrop_img(Url, photo_id) //confarming property delete
                                        {
                                            var target_selector_to_update = '#item_no_' + photo_id;
                                            $(target_selector_to_update).html('Loading.....');
                                            $.ajax({
                                                url: Url,
                                                complete: function (data, text) {
                                                    $(target_selector_to_update).load("update_profile_photo.php<?php echo $user_idd; ?> " + target_selector_to_update + ' *');
                                                }
                                            });
                                            $(".fancybox").fancybox();
                                        }


                                        function crop_img(Url, photo_id) //confarming property delete
                                        {
                                            var target_selector_to_update = 'body';
                                            $(target_selector_to_update).html('Loading.....');
                                            $(target_selector_to_update).load(Url);
                                        }

                                        function Confrim_Profile_Photo(Url, photo_id) //confarming property delete
                                        {
                                            if (confirm("Are you sure you want to make this Profile Photo ?"))
                                            {
                                                var target_selector_to_update = '#m_profile .current_profile_pic';
                                                $(target_selector_to_update).html('Loading.....');
                                                $.ajax({
                                                    url: Url,
                                                    complete: function (data, text) {
                                                        $(target_selector_to_update).load('update_profile_photo.php ' + target_selector_to_update + ' *');
                                                        photo_id_of_prfile_pic = photo_id;
                                                    }
                                                });
                                            }
                                            $(".fancybox").fancybox();
                                        }

</script> 

<?php
include('../_includes/footer.php');
?>
