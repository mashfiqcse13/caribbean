<?php
include('include/application_top.php');
cmslogin();

if ((isset($_POST['submit']))AND ( $_POST['submit'] == 'Add Music')) {

    /* move upload photo in temp folder */
    //get the file ext:
    $filename = $_FILES['mp3_file']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "add") {
        $result = mysql_query("SELECT file_attached FROM tbl_contact where id='" . $_REQUEST['id'] . "'");

        while ($row = mysql_fetch_array($result)) {
            $audio = $row['file_attached'];
            $stripslash = explode('/', $row['file_attached']);
        }

        //$tempdir = $_SERVER['DOCUMENT_ROOT']."/uploadcontact/index.php";
        //echo $audio;uploadcontact/newname2014-06-04-22-28-10.mp3
        //echo $_SERVER['DOCUMENT_ROOT'];/var/zpanel/hostdata/zadmin/public_html/caribbeancirclestars_com

        $file_ext = ".mp3";
    }
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
        insertData($data, $table);

        $lid = mysql_insert_id();

        if (!isset($_REQUEST['id'])) {

            $source_path = $_FILES['mp3_file']['tmp_name'];
            $destination = "../_temp/" . $lid . ".mp3";
            upload_my_file($source_path, $destination);

            $file = "../_temp/" . $lid . ".mp3";
            $newfile = "../_uploads/site_music/" . $lid . ".mp3";
            copy($file, $newfile);

            /* delete temp folder file */
            unlink("../_temp/" . $lid . ".mp3");
        } else {
            $file1 = "../uploadcontact/" . $stripslash['1'];
            $newfile1 = "../_uploads/site_music/" . $stripslash['1'];
            $newfile11 = "../_uploads/site_music/" . $lid . ".mp3";

            if (!copy($file1, $newfile1)) {
                echo "failed to copy from media to music...";
            }
            rename($newfile1, $newfile11);
        }
        header("location:add_site_music.php?op=a ");
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
<h1>ADD MUSIC</h1>
<p style=""><a href="#" onclick="goBack()" class="button" style=" margin:10px 0px 0px 15px; color:#FFFFFF;">Back</a></p>

<div class="add_site_mp3">
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" enctype="multipart/form-data" id="add_mp3_songs" >
        <input type="hidden" value="<?php echo $_REQUEST['id']; ?>" name="id">
        <input type="hidden" value="<?php echo $_REQUEST['action']; ?>" name="action">
        <p>
            <label>Name:</label>
            <input type="text" name="name" value="" placeholder="Enter Song Name" onblur="if (this.value == '')
                        this.placeholder = 'Enter Song Name';" onfocus="if (this.value == 'Enter Song Name')
                                    this.value = '';" class="required">
        </p>
        <p>
            <label>Artist:</label>
            <input type="text" name="artist" value="" class="required" placeholder="Enter Artist Name" onblur="if (this.value == '')
                        this.placeholder = 'Enter Artist Name';" onfocus="if (this.value == 'Enter Artist Name')
                                    this.value = '';">
        </p>
        <p>
            <label>
                Select a MP3 File:
            </label>
            <?php
            if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "add") {
                echo "This Song is Attached !!";
            } else {
                ?>
                <input type="file" name="mp3_file" class="required">
                <?php
            }
            ?>
        </p>
        <p>
            <input type="submit" name="submit" value="Add Music" class="button">
        </p>
    </form>
</div>           
<?php include('include/footer.php'); ?>
<script>
    function goBack() {
        window.history.back();
    }
</script>