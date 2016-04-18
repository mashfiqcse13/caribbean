<?php
//print_r($_POST);
include('../_includes/application-top.php');
ChecknontalentLogin();

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Video')) {

    extract($_POST);

    if ($video_type == 0) {


        if ((isset($_FILES['file_photo']['name'])) && ($_FILES['file_photo']['name'] != '')) {
            /* USER IMAGE UPLOAD */
            $filename = $_FILES['file_photo']['name'];
            $file_ext = strrchr($filename, '.');

            $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
            if (!in_array($file_ext, $whitelist)) {
                $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
            } else {
                $data = array(
                    "user_id" => $_SESSION['user_id'],
                    "video_name" => mysql_real_escape_string(trim($_POST['video_name'])),
                    "video_type" => mysql_real_escape_string(trim($_POST['video_type'])),
                    "video_code" => mysql_real_escape_string(trim($_POST['video_code'])),
                    "status" => '1'
                );
                $table = "tbl_profile_videos";
                insertData($data, $table);
                $vid = mysql_insert_id();

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



                $MSG1 = "Your Video File upload sucessfully!";
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
                            $data = array(
                                "user_id" => $_SESSION['user_id'],
                                "video_name" => mysql_real_escape_string(trim($_POST['video_name'])),
                                "video_type" => mysql_real_escape_string(trim($_POST['video_type'])),
                                "status" => '1'
                            );
                            $table = "tbl_profile_videos";
                            insertData($data, $table);
                            $vid = mysql_insert_id();

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

                            $MSG1 = "Your Video File upload sucessfully!";
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

                    $data = array(
                        "user_id" => $_SESSION['user_id'],
                        "video_name" => mysql_real_escape_string(trim($_POST['video_name'])),
                        "video_type" => mysql_real_escape_string(trim($_POST['video_type'])),
                        "status" => '1'
                    );
                    $table = "tbl_profile_videos";
                    insertData($data, $table);
                    $vid = mysql_insert_id();

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


                    $MSG1 = "Your Video File upload sucessfully!";
                }
            }

            if ((isset($_FILES['mp4_file']['name'])) && ($_FILES['mp4_file']['name'] != '')) {
                $filename1 = $_FILES['mp4_file']['name'];
                $file_ext1 = strrchr($filename1, '.');

                $whitelist1 = array(".mp4");

                if (!in_array($file_ext1, $whitelist1)) {
                    $MSG = 'Not allowed extension,please upload mp4 file only!';
                } else {

                    $data = array(
                        "user_id" => $_SESSION['user_id'],
                        "video_name" => mysql_real_escape_string(trim($_POST['video_name'])),
                        "video_type" => mysql_real_escape_string(trim($_POST['video_type'])),
                        "status" => '1'
                    );
                    $table = "tbl_profile_videos";
                    insertData($data, $table);
                    $vid = mysql_insert_id();

                    $source_path2 = $_FILES['mp4_file']['tmp_name'];
                    $destination2 = "../_temp/" . $vid . ".mp4";
                    upload_my_file($source_path2, $destination2);

                    /* copy upload file in profile_music folder copy in to temp folder */
                    $file = "../_temp/" . $vid . ".mp4";
                    $newfile = "../_uploads/profile_video/" . $vid . ".mp4";
                    copy($file, $newfile);

                    /* delete temp folder file */
                    unlink("../_temp/" . $vid . ".mp4");



                    $MSG1 = "Your Video File upload sucessfully!";
                }
            }
        } else {


            $data = array(
                "user_id" => $_SESSION['user_id'],
                "video_name" => mysql_real_escape_string(trim($_POST['video_name'])),
                "video_type" => mysql_real_escape_string(trim($_POST['video_type'])),
                "status" => '1'
            );
            $table = "tbl_profile_videos";
            insertData($data, $table);
            $vid = mysql_insert_id();

            $parameters = "id='" . $vid . "'";

            updateData($data, $table, $parameters);

            $MSG1 = "Your Video File upload sucessfully!";
        }
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_video').validate();
    });

    function clickme(id)
    {
        if (id == 1)
        {
            $('#file_type').slideDown('slow');
            $('#you_tube').slideUp('slow');
        }
        if (id == 0)
        {
            $('#you_tube').slideDown('slow');
            $('#file_type').slideUp('slow');
        }
    }

</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Add Video</h1>
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
        <?php
    }
    if (isset($MSG1)) {
        ?>
        <p class="msg">
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="manage_video.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post"  enctype="multipart/form-data" id="add_video" name="add_video">
                    <p>
                        <label>
                            Video Title:
                        </label>
                        <input type="text" name="video_name" value="" class="required">
                    </p>
                    <p>
                        <label>
                            Select Photo:
                        </label>
                        <input type="file" name="file_photo" class="required">
                    </p>
                    <p>
                        <label>
                            Video Type : 
                        </label>
                        <select name="video_type" onchange="return clickme(this.value);">
                            <option value="1">File</option>
                            <option value="0">You Tube</option>
                        </select>
                    </p>
                    <div id="file_type">
                        <p>
                            <label>
                                Select Video:
                            </label>
                            <input type="file" name="mp4_file" class="required">
                        </p>
                        <p><span class="form_nots">Please upload mp4 file only</span></p>
                    </div>
                    <div id="you_tube">
                        <p>
                            <label style="vertical-align:top;">
                                Embed Code:
                            </label>
                            <TEXTAREA NAME="video_code" COLS="40" ROWS="6" class="required" ></TEXTAREA>
                           </p>
                          </div>
                          
                          <p>
                            <input type="submit" name="submit" value="Add Video" class="button">
                          </p>
                    </form>
                </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
