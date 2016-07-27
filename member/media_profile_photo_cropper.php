<?php
include('../_includes/application-top.php');
ChecktalentLogin();

include('../_includes/header.php');

require_once '../_includes/Croper.php';
include('../_includes/class.Profile_pic.php');

$Profile_photo = new Profile_photo($_SESSION["user_id"], "member");
if (isset($_GET['img_reset'])) {
    $sql = "UPDATE `tbl_contact` SET `file_attached` = '$file_attached_updated' WHERE `id` = '{$_POST['photoid']}'";
    $result = mysqli_query($link,$sql);
}
if (isset($_POST['submit'])) {
    $Profile_photo->crop($_POST['photoid'], json_encode($_POST['crop']));
}
if (!empty($_GET['photoid']) && !empty($_GET['action']) && $_GET['action'] == "uncrop") {
    $Profile_photo->uncrop($_GET['photoid']);
}
?>
<link href="../_css/cropper/cropper.css" rel="stylesheet" type="text/css"/>
<script src="../_script/cropper/jquery.min.js" type="text/javascript"></script>
<script src="../_script/cropper/cropper.js" type="text/javascript"></script>
<div style="margin:0 auto; width:100%; padding:1px; background:#fff;" id="content_body">
    <?php
    if (isset($_GET['photoid'])) {

        $target_image_details = $Profile_photo->get_file_by($_GET['photoid']);
        $target_image_url = $target_image_details['file_url'];
        ?>
        <div style="display: block;  margin: 0 auto; max-height: 600px">
            <img id="image" src="<?php echo $target_image_url; ?>">
        </div>

        <form action="" method="post">
            <input type="hidden" name='photoid' value="<?php echo $_GET['photoid'] ?>"/>
            <input id="X" type="hidden" name='crop[x]'/>
            <input id="Y" type="hidden" name='crop[y]'/>
            <input id="width" type="hidden" name='crop[width]'/>
            <input id="height" type="hidden" name='crop[height]'/>
            <input id="rotate" type="hidden" name='crop[rotate]'/>
            <input id="scaleX" type="hidden" name='crop[scaleX]'/>
            <input id="scaleY" type="hidden" name='crop[scaleY]'/>
            <input type="submit" name="submit" value="Save"/>
            <input type="button"  onclick="window.location = 'manage_photo.php<?php echo "?id=" . $_SESSION['user_id']; ?>'" value="Cancel"/>
        </form>

        <script>
            $('#image').cropper({
                dragMode: 'move',
                restore: false,
                guides: false,
                highlight: false,
                aspectRatio: 1 / 1,
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