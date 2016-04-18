<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Add Music')) {

    /* move upload photo in temp folder */
    //get the file ext:
    $filename = $_FILES['mp3_file']['name'];
    $file_ext = strrchr($filename, '.');
    //check if its allowed or not:
    // $whitelist = array(".mp3"); 
    if ($file_ext <> ".mp3") {
        $MSG = 'Not allowed extension,please upload mp3 only!';
    } else {

        $data = array(
            "user_id" => $_SESSION['talent_id'],
            "music_title" => mysql_real_escape_string(trim($_POST['music_titl'])),
            "music_details" => mysql_real_escape_string(trim($_POST['music_details'])),
            "status" => '1'
        );
        $table = "tbl_profile_music";
        insertData($data, $table);
        $lid = mysql_insert_id();

        $source_path = $_FILES['mp3_file']['tmp_name'];
        $destination = "../_temp/" . $lid . ".mp3";
        upload_my_file($source_path, $destination);

        /* copy upload file in profile_music folder copy in to temp folder */
        $file = "../_temp/" . $lid . ".mp3";
        $newfile = "../_uploads/profile_music/" . $lid . ".mp3";
        copy($file, $newfile);

        /* delete temp folder file */
        unlink("../_temp/" . $lid . ".mp3");
        $MSG1 = "Your Music File upload sucessfully.";
    }
}


include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_mp3_songs').validate();
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Add Music</h1>
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
    <p style="text-align:right"><a href="manage_music.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" >
                    <p>
                        <label>Music Title:</label>
                        <input type="text" name="music_titl" value="" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">Additional Notes:</label>

                        <TEXTAREA NAME="music_details" COLS=40 ROWS=6 ></TEXTAREA></p>
                            <p>
                              <label>
                                 Select a MP3 File:
                              </label>
                              <input type="file" name="mp3_file" class="required">
                            </p>
                            <p>
                              <input type="submit" name="submit" value="Add Music" class="button">
                            </p>
                      </form>    
                  </div><!--END CLASS m_profile_right PART -->
            </div><!--END CLASS m_profile PART -->
			</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
