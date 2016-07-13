<?php
include('../_includes/application-top.php');
ChecknontalentLogin();


require_once '../_includes/Croper.php';
include('../_includes/class.Profile_pic.php');

$profile_pic = new Profile_pic($_SESSION["user_id"], "talent");
if (isset($_GET['img_reset'])) {
    $sql = "UPDATE `tbl_contact` SET `file_attached` = '$file_attached_updated' WHERE `id` = '{$_POST['photoid']}'";
    $result = mysql_query($sql);
}
if (isset($_POST['sava_and_make_propic'])) {
    $profile_pic->crop($_POST['photoid'], json_encode($_POST['crop']), FALSE);
    $profile_pic->select_from_gallery($_POST['photoid']);
}
if (isset($_POST['submit'])) {
    $profile_pic->crop($_POST['photoid'], json_encode($_POST['crop']));
}
include('../_includes/header.php');
?>
<link href="../_css/cropper/cropper.css" rel="stylesheet" type="text/css"/>
<script src="../_script/cropper/jquery.min.js" type="text/javascript"></script>
<script src="../_script/cropper/cropper.js" type="text/javascript"></script>
<style>
    .button,a.button  {
        cursor: pointer;
        margin: 0;
    }
    .button:hover {
        background-color: #ff9900;
        color: #ffffff;
        text-decoration: none;
    }
</style>
<div style="margin:0 auto; width:100%; padding:1px; background:#fff;" id="content_body">
    <?php
    if (isset($_GET['photoid'])) {

        $target_image_details = $profile_pic->get_file_by($_GET['photoid']);
        $target_image_url = $target_image_details['file_url'];
        ?>
        <div style="display: block;  margin: 0 auto; max-height: 600px">
            <img id="image" src="<?php echo $target_image_url; ?>">
        </div>

        <form id="ajax_form" action="media_img_cropper.php" method="post">
            <input type="hidden" name='photoid' value="<?php echo $_GET['photoid'] ?>"/>
            <input type="hidden" name='id' value="<?php echo $_SESSION['user_id'] ?>"/>
            <input id="X" type="hidden" name='crop[x]'/>
            <input id="Y" type="hidden" name='crop[y]'/>
            <input id="width" type="hidden" name='crop[width]'/>
            <input id="height" type="hidden" name='crop[height]'/>
            <input id="rotate" type="hidden" name='crop[rotate]'/>
            <input id="scaleX" type="hidden" name='crop[scaleX]'/>
            <input id="scaleY" type="hidden" name='crop[scaleY]'/>
            <br>
            <input class="button" type="submit" name="submit" value="Save"/>
            <input class="button" type="submit" name="sava_and_make_propic" value="Save and Make Profile Picture"/>
            <a class="button" href="update_profile_photo.php<?php echo $user_idd; ?>">Cancel</a>
        </form>

        <script src="../_script/jquery.form.min.js" type="text/javascript"></script>
        <script>
            $(document).ready(function () {
                $('#ajax_form').ajaxForm({
                    dataType: 'json',
                    success: function (responseText, statusText) {
                        if (responseText.msg != null) {
                            alert(responseText.msg);
                        }
                        if (responseText.destination_url != null) {
                            $('body').load(responseText.destination_url);
                        } else {
                            alert("Failed to upload");
                        }
                        cosole.log(responseText);
                    }
                });

            });
            $('#image').cropper({
                dragMode: 'move',
                restore: false,
                guides: false,
                highlight: false,
                aspectRatio: 4 / 5,
                crop: function (e) {
                    // Output the result data for cropping image.
                    console.log("X :" + e.x);
                    console.log("Y :" + e.y);
                    console.log("width :" + e.width);
                    console.log("height :" + e.height);
                    console.log("rotate :" + e.rotate);
                    console.log("scaleX :" + e.scaleX);
                    console.log("scaleY :" + e.scaleY);

                    $('form #X').val(e.x);
                    $('form #Y').val(e.y);
                    $('form #width').val(e.width);
                    $('form #height').val(e.height);
                    $('form #rotate').val(e.rotate);
                    $('form #scaleX').val(e.scaleX);
                    $('form #scaleY').val(e.scaleY);
                }
            });
        </script>
        <?php
    } else {
        die('<script>
            alert("No Photo found");
            window.location.assign("' . SITE_URL . 'talents/update_profile_photo.php");
        </script>');
    }
    ?>
</div>
<?php
include('../_includes/footer.php');
?>