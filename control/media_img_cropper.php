<?php
include('include/application_top.php');
require_once '../_includes/Croper.php';
cmslogin();
if (isset($_GET['img_reset'])) {

    $sql = "UPDATE `tbl_contact` SET `file_attached` = '$file_attached_updated' WHERE `id` = '{$_POST['pic_id']}'";
    $result = mysql_query($sql);
}
if (isset($_POST['submit'])) {

    $sql = "SELECT * FROM tbl_contact where id = '{$_POST['pic_id']}'";
    $result = mysql_query($sql);

    if (!$result) {
        die("Retrieving records from contact table's query faild:" . mysql_query());
    }

    $row = mysql_fetch_array($result);
    $stripslash = explode('/', $row['file_attached']);
    $file = explode('.', $stripslash['1']);

    $target_image_url = SITE_URL1 . str_replace('-croped', '', $row['file_attached']);
    $target_image_path = '../' . str_replace('-croped', '', $row['file_attached']);
    $resizing_data = json_encode($_POST['crop']);

    $file[0] = str_replace('-croped', '', $file[0]);

    $file_attached_updated = "uploadcontact/{$file[0]}-croped.{$file[1]}";
    $destUrl = SITE_URL1 . $file_attached_updated;
    $destPath = "../$file_attached_updated";
    $des_file = fopen($destPath, 'w');
    fclose($des_file);

    $croper = new Croper();
    $croper->resize_existing($target_image_path, $resizing_data, $destPath);
    if (!empty($croper->getMsg())) {
        die($croper->getMsg());
    }

    $sql = "UPDATE `tbl_contact` SET `file_attached` = '$file_attached_updated' WHERE `id` = '{$_POST['pic_id']}'";
    $result = mysql_query($sql);

    die('<script>
            window.location.assign("' . SITE_URL . 'media.php");
        </script>');
//    die('<img src="' . $destUrl . '"/>');
}
include('include/header.php');
?>
<link href="../_css/cropper/cropper.css" rel="stylesheet" type="text/css"/>
<script src="../_script/cropper/jquery.min.js" type="text/javascript"></script>
<script src="../_script/cropper/cropper.js" type="text/javascript"></script>
<div style="margin:50px auto; width:97%; padding:1px; background:#fff;" id="content_body">
    <?php
    if (isset($_GET['pic_id'])) {

        $sql = "SELECT * FROM tbl_contact where id = '{$_GET['pic_id']}'";
        $result = mysql_query($sql);

        if (!$result) {
            die("Retrieving records from contact table's query faild:" . mysql_query());
        }
        $row = mysql_fetch_array($result);
        if (isset($_GET['img_reset'])) {

            $sql = "UPDATE `tbl_contact` SET `file_attached` = '" . str_replace('-croped', '', $row['file_attached']) . "' WHERE `id` = '{$_GET['pic_id']}'";
            $result = mysql_query($sql);
            die('<script>
            window.location.assign("' . SITE_URL . 'media.php");
        </script>');
        }
        $stripslash = explode('/', $row['file_attached']);
        $file = explode('.', $stripslash['1']);


        $row['file_attached'] = str_replace('-croped', '', $row['file_attached']);

        $target_image_url = SITE_URL1 . $row['file_attached'];
        ?>
        <div style="display: block;  margin: 0 auto;">
            <img id="image" src="<?php echo $target_image_url; ?>">
        </div>

        <form action="" method="post">
            <input type="hidden" name='pic_id' value="<?php echo $row['id'] ?>"/>
            <input id="X" type="hidden" name='crop[x]'/>
            <input id="Y" type="hidden" name='crop[y]'/>
            <input id="width" type="hidden" name='crop[width]'/>
            <input id="height" type="hidden" name='crop[height]'/>
            <input id="rotate" type="hidden" name='crop[rotate]'/>
            <input id="scaleX" type="hidden" name='crop[scaleX]'/>
            <input id="scaleY" type="hidden" name='crop[scaleY]'/>
            <input type="submit" name="submit" value="Save"/>
            <input type="button"  onclick="window.history.go(-1)" value="Back"/>
        </form>

        <script>
            $('#image').cropper({
                dragMode: 'move',
                restore: false,
                guides: false,
                highlight: false,
                //        aspectRatio: 16 / 9,
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
    <?php } ?>
</div>