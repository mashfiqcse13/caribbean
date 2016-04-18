<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if (isset($_GET['id'])) {
    $sql = mysql_query("SELECT * FROM  tbl_profile_videos WHERE id='" . $_GET['id'] . "' order by id ");
    $result = mysql_fetch_assoc($sql);
    //print_r($result);
}

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update Video')) {

    extract($_POST);

    if ($vtype == 0) {


        if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
            /* USER IMAGE UPLOAD */
            $filename = $_FILES['file_photo']['name'];
            $file_ext = strrchr($filename, '.');

            $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
            if (!in_array($file_ext, $whitelist)) {
                $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
            } else {
                $source_path1 = $_FILES['file_photo']['tmp_name'];
                $destination1 = "../_temp/" . $vid . ".jpg";
                upload_my_file($source_path1, $destination1);

                /* copy upload file in profile_music folder copy in to temp folder */
                $source = "../_temp/" . $vid . '.jpg';
                $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                $size = PROFILE_PHOTO_THUMB;
                create_thumb($source, $size, $destination);

                /* delete temp folder file */
                unlink("../_temp/" . $vid . ".jpg");

                $data = array(
                    "video_name" => mysql_real_escape_string(trim($video_name)),
                    "video_code" => mysql_real_escape_string(trim($video_code)),
                    "status" => $status,
                );
                $table = "tbl_profile_videos";

                $parameters = "id='" . $vid . "'";

                updateData($data, $table, $parameters);

                header("location:manage_video.php?op=u");
            }
        } else {
            $data = array(
                "video_name" => mysql_real_escape_string(trim($video_name)),
                "video_code" => mysql_real_escape_string(trim($video_code)),
                "status" => $status,
            );

            $table = "tbl_profile_videos";

            $parameters = "id='" . $vid . "'";

            updateData($data, $table, $parameters);

            header("location:manage_video.php?op=u");
        }
    } else {

        if (((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) && (isset($_FILES['mp4_file']['name']) && ($_FILES['mp4_file']['name'] != ''))) {

            if (isset($_FILES['file_photo'])) {
                /* USER IMAGE UPLOAD */
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {
                    if (isset($_FILES['mp4_file']['name'])) {
                        $filename1 = $_FILES['mp4_file']['name'];
                        $file_ext1 = strrchr($filename1, '.');

                        $whitelist1 = array(".mp4");

                        if (!in_array($file_ext1, $whitelist1)) {
                            $MSG = 'Not allowed extension,please upload mp4 file only!';
                        } else {
                            $source_path1 = $_FILES['file_photo']['tmp_name'];
                            $destination1 = "../_temp/" . $vid . ".jpg";
                            upload_my_file($source_path1, $destination1);

                            /* copy upload file in profile_music folder copy in to temp folder */
                            $source = "../_temp/" . $vid . '.jpg';
                            $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                            $size = PROFILE_PHOTO_THUMB;
                            create_thumb($source, $size, $destination);

                            /* delete temp folder file */
                            unlink("../_temp/" . $vid . ".jpg");

                            $source_path2 = $_FILES['mp4_file']['tmp_name'];
                            $destination2 = "../_temp/" . $vid . ".mp4";
                            upload_my_file($source_path2, $destination2);

                            /* copy upload file in profile_music folder copy in to temp folder */
                            $file = "../_temp/" . $vid . ".mp4";
                            $newfile = "../_uploads/profile_video/" . $vid . ".mp4";
                            copy($file, $newfile);

                            /* delete temp folder file */
                            unlink("../_temp/" . $vid . ".mp4");

                            $data = array(
                                "video_name" => mysql_real_escape_string(trim($video_name)),
                                "status" => $status,
                            );
                            $table = "tbl_profile_videos";
                            $parameters = "id='" . $vid . "'";
                            updateData($data, $table, $parameters);

                            header("location:manage_video.php?op=u");
                        }
                    }
                }
            }
        } elseif (((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) || (isset($_FILES['mp4_file']['name']) && ($_FILES['mp4_file']['name'] != ''))) {

            if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
                $filename = $_FILES['file_photo']['name'];
                $file_ext = strrchr($filename, '.');

                $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

                if (!in_array($file_ext, $whitelist)) {
                    $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
                } else {

                    $source_path1 = $_FILES['file_photo']['tmp_name'];
                    $destination1 = "../_temp/" . $vid . ".jpg";
                    upload_my_file($source_path1, $destination1);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $source = "../_temp/" . $vid . '.jpg';
                    $destination = "../_uploads/video_photo/" . $vid . ".jpg";
                    $size = PROFILE_PHOTO_THUMB;
                    create_thumb($source, $size, $destination);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".jpg");

                    $data = array(
                        "video_name" => mysql_real_escape_string(trim($video_name)),
                        "status" => $status,
                    );
                    $table = "tbl_profile_videos";
                    $parameters = "id='" . $vid . "'";
                    updateData($data, $table, $parameters);

                    header("location:manage_video.php?op=u");
                }
            }

            if ((isset($_FILES['mp4_file']['name'])) && ($_FILES['mp4_file']['name'] != '')) {
                $filename1 = $_FILES['mp4_file']['name'];
                $file_ext1 = strrchr($filename1, '.');

                $whitelist1 = array(".mp4");

                if (!in_array($file_ext1, $whitelist1)) {
                    $MSG = 'Not allowed extension,please upload mp4 file only!';
                } else {
                    $source_path2 = $_FILES['mp4_file']['tmp_name'];
                    $destination2 = "../_temp/" . $vid . ".mp4";
                    upload_my_file($source_path2, $destination2);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $file = "../_temp/" . $vid . ".mp4";
                    $newfile = "../_uploads/profile_video/" . $vid . ".mp4";
                    copy($file, $newfile);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".mp4");

                    $data = array(
                        "video_name" => mysql_real_escape_string(trim($video_name)),
                        "status" => $status,
                    );
                    $table = "tbl_profile_videos";
                    $parameters = "id='" . $vid . "'";
                    updateData($data, $table, $parameters);

                    header("location:manage_video.php?op=u");
                }
            }
        } else {


            $data = array(
                "video_name" => mysql_real_escape_string(trim($video_name)),
                "status" => $status,
            );
            $table = "tbl_profile_videos";

            $parameters = "id='" . $vid . "'";

            updateData($data, $table, $parameters);

            header("location:manage_video.php?op=u");
        }
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#update_video').validate();
    });

    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'scrolling': 'no',
            'autoScale': true,
            'titlePosition': 'over',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Video update</h1>
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
    <?php }
    ?>
    <p style="text-align:right"><a href="manage_video.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="update_video" >
                    <input type="hidden" name="vid" value="<?php echo $result['id']; ?>" />
                    <input type="hidden" name="vtype" value="<?php echo $result['video_type']; ?>" />
                    <p>
                        <label>
                            Video Title:
                        </label>
                        <input type="text" name="video_name" value="<?php echo $result['video_name']; ?>" class="required">
                    </p>
                    <p>
                        <label>
                            Select Photo:
                        </label>
                        <input type="file" name="file_photo" >
                    </p>

                    <?php
                    if ($result['video_type'] == 1) {
                        ?>
                        <div id="file_type1">
                            <p style="margin-left:140px;">
                                <a id="video" href="video_play.php?filename=../_uploads/profile_video/<?php echo $result["id"]; ?>.mp4">
                                    <img src="../_uploads/video_photo/<?php echo $result["id"]; ?>.jpg" title="Play Video"/><br/>
                                </a>
                            </p>
                            <label>
                                Select Video:
                            </label>
                            <input type="file" name="mp4_file" >
                        </div>
                    <?php } else { ?>
                        <div id="you_tube1">
                            <p style="margin-left:140px;">
                                <a id="video" href="video_play.php?id=<?php echo $result["id"]; ?>">
                                    <img src="../_uploads/video_photo/<?php echo $result["id"]; ?>.jpg"/>
                                </a>
                            </p>
                            <label style="vertical-align:top;">
                                Video Code:
                            </label>
                            <TEXTAREA NAME="video_code" COLS="40" ROWS="6" ><?php echo $result["video_code"]; ?></TEXTAREA>
                                    </div>
                    <?php } ?>
                            <p>
                                <label>
                                    Status:
                                </label>
                                <select name="status">
                                  <option <?php
                            if ($result["status"] == "1") {
                                echo "selected='selected'";
                            }
                            ?> value="1">Active</option>
                                  <option  <?php
                        if ($result["status"] == "0") {
                            echo "selected='selected'";
                        }
                        ?> value="0">Inactive</option>
                                </select>
                            </p>
                            <p>
                              
                            <input type="submit" name="submit" value="Update Video"  class="button">
                          </p>
                      </form>    
                </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
