<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
$sql = mysql_query("SELECT * FROM  tbl_profile_music WHERE id='" . $_GET['id'] . "' order by id ");
$result = mysql_fetch_assoc($sql);
//print_r($result);
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update Music')) {
    if ((isset($_FILES['mp3_file']['name'])) && ($_FILES['mp3_file']['name'] != '')) {
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
                "music_title" => mysql_real_escape_string(trim($_POST['music_titl'])),
                "music_details" => mysql_real_escape_string(trim($_POST['music_details'])),
                "status" => $_POST['status'],
            );
            $table = "tbl_profile_music";
            $parameters = "id='" . $_POST["hedden"] . "'";
            updateData($data, $table, $parameters);

            $source_path = $_FILES['mp3_file']['tmp_name'];
            $destination = "../_temp/" . $_POST['hedden'] . ".mp3";
            upload_my_file($source_path, $destination);

            /* copy upload file in profile_music folder copy in to temp folder */
            $file = "../_temp/" . $_POST['hedden'] . ".mp3";
            $newfile = "../_uploads/profile_music/" . $_POST['hedden'] . ".mp3";
            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $_POST['hedden'] . ".mp3");
            //echo "Your Music File upload sucessfully!";
            header("Location:manage_music.php?op=u");
        }
    } else {
        $data = array(
            "music_title" => mysql_real_escape_string(trim($_POST['music_titl'])),
            "music_details" => mysql_real_escape_string(trim($_POST['music_details'])),
            "status" => $_POST['status'],
        );
        $table = "tbl_profile_music";
        $parameters = "id='" . $_POST["hedden"] . "'";
        updateData($data, $table, $parameters);
        header("Location:manage_music.php?op=u");
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
    <h1>Update Music</h1>
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
    <p style="text-align:right"><a href="manage_music.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_left"><!--START CLASS m_profile_left PART -->

            </div><!--END CLASS m_profile_left PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" >
                    <input type="hidden" name="hedden" value="<?php echo $result['id']; ?>" />
                    <p>
                        <label>
                            Music Title:
                        </label>
                        <input type="text" name="music_titl" value="<?php echo $result['music_title']; ?>" class="required">
                    </p>
                    <p>
                        <label style="vertical-align:top;">
                            Additional Notes:
                        </label>
                        <TEXTAREA NAME="music_details" COLS=40 ROWS=6><?php echo $result['music_details']; ?></TEXTAREA>
                        </p>
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
                            <label>
                              Select a MP3 File:
                            </label>
                          <input type="file" name="mp3_file"  value="">
                       </p>
                       <p>
                        <input type="submit" name="submit" value="Update Music" class="button">
                      </p>
                  </form>    
              </div><!--END CLASS m_profile_right PART -->
          </div><!--END CLASS m_profile PART -->
		</div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->

<?php
include('../_includes/footer.php');
?>
