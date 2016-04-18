<?php
include('include/application_top.php');
cmslogin();
$sql = mysql_query("SELECT * FROM  tbl_site_music WHERE id='" . $_GET['id'] . "' order by id ");
$result = mysql_fetch_assoc($sql);
//print_r($result);
if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Update Music')) {
    if ((isset($_FILES['mp3_file']['name'])) && ($_FILES['mp3_file']['name'] != '')) {
        /* move upload photo in temp folder */
        //get the file ext:
        $filename = $_FILES['mp3_file']['name'];
        $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

        //$file_ext = strrchr($filename, '.');
        //check if its allowed or not:
        // $whitelist = array(".mp3"); 
        if ($file_ext <> ".mp3") {
            $MSG = 'Not allowed extension,please upload mp3 only!';
        } else {
            $data = array(
                "name" => mysql_real_escape_string(trim($_POST['name'])),
                "artist" => mysql_real_escape_string(trim($_POST['artist'])),
                "status" => '1'
            );
            $table = "tbl_site_music";
            $parameters = "id='" . $_POST["hedden"] . "'";
            updateData($data, $table, $parameters);

            $source_path = $_FILES['mp3_file']['tmp_name'];
            $destination = "../_temp/" . $_POST['hedden'] . ".mp3";
            upload_my_file($source_path, $destination);

            /* copy upload file in profile_music folder copy in to temp folder */
            $file = "../_temp/" . $_POST['hedden'] . ".mp3";
            $newfile = "../_uploads/site_music/" . $_POST['hedden'] . ".mp3";
            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $_POST['hedden'] . ".mp3");
            //echo "Your Music File upload sucessfully!";
            header("Location:manage_music.php?op=u");
        }
    } else {
        $data = array(
            "name" => mysql_real_escape_string(trim($_POST['name'])),
            "artist" => mysql_real_escape_string(trim($_POST['artist'])),
            "status" => $_POST['status']
        );
        $table = "tbl_site_music";
        $parameters = "id='" . $_POST["hedden"] . "'";
        updateData($data, $table, $parameters);
        header("Location:manage_music.php?op=u");
    }
}
?>
<?php include('include/header.php'); ?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_mp3_songs').validate();
    });
</script>

<?php
if (isset($_GET['op'])) {
    ?>
    <p class="msg">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
            echo "Your Music File upload sucessfully.";
        }
        ?>
    </p>
    <?php
}
if (isset($MSG)) {
    ?>
    <p class="err">
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo $MSG;
        }
        ?>
    </p>
<?php } ?>
<h1>EDIT MUSIC</h1>
<p style=""><a href="manage_music.php" class="button" style="margin:10px 0px 0px 15px; color:#FFFFFF;">Back</a></p>
<div class="add_site_mp3">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" >
        <input type="hidden" name="hedden" value="<?php echo $result['id']; ?>" />
        <p>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $result['name']; ?>" class="required">
        </p>
        <p>
            <label>Artist:</label>
            <input type="text" name="artist" value="<?php echo $result['artist']; ?>" class="required">
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
            <input type="file" name="mp3_file"  value=" ">
        </p>
        <p>
            <input type="submit" name="submit" value="Update Music" class="button">
        </p>
    </form>
</div>           
<?php include('include/footer.php'); ?>
