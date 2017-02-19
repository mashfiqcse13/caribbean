<?php
include('include/application_top.php');


include '../_includes/class.database.php';
include '../_includes/class.media.php';
include './include/common_function.php';

$db = new DBClass(db_host, db_username, db_passward, db_name);
//CheckLoginForum();
//echo $_SESSION['user_id'];
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Topic')) {
    /* if(isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] !='') {
      $uid = $_SESSION['talent_id'];
      }elseif(isset($_SESSION['user_id']) AND $_SESSION['user_id'] != ''){
      $uid = $_SESSION['user_id'];
      }else{
      $uid ="0";//This is for admin
      } */

    $uid = "0"; //This is for admin
    if ((isset($_POST['forum_details'])) && ($_POST['forum_details'] != '')) {
        $data = array(
            "uid" => $uid,
            "forum_topic" => mysqli_real_escape_string($link, trim($_POST['forum_topic'])),
            "forum_details" => mysqli_real_escape_string($link, trim($_POST['forum_details'])),
            "view_count" => '0',
            "media_id" => mysqli_real_escape_string($link, trim($_POST['media_id'])),
            "is_admin" => 'Yes'
        );
        $table = "tbl_forum_topics";
        insertData($data, $table);

        /* Added Activity Below */

        $uname = ("admin"); // for admin
/////////////////////////////////////////////////


        $MSG = 'Your Topic Added sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Topic !";
    }
}
include('include/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_forum').validate();

    });

</script>
<script type="text/javascript">
    /*CKEDITOR.replace( 'description');
     CKEDITOR.on("instanceReady", function(event)
     {
     $("#add_forum").validate(
     { rules: { title: {required: true}, description: {required: true}, stuff: {required: true} } });
     });*/
</script>
<style>
    .content {
        padding: 0 0 25px 25px;
    }
</style>
<div class="content">
    <h1>Add Topic</h1>
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
        <?php
    }
    if (isset($MSG1)) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
    <?php }
    ?>
    <p style="text-align:right">
        <?php if (!empty($_GET['media_id'])) { ?>
            <a href="#" onclick="window.history.back();" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
        <?php } else { ?>
            <a href="forum_record.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
        <?php } ?>
    </p><br />
    <div style="width:70%;">
        <div class="form_class">
            <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post" id="add_forum">
                <p>
                    <label for="email">Topic:</label>
                    <input  type="text" name="forum_topic" value="" maxlength="100" class="required" />
                </p>
                <p>
                    <a href="#media" id="add_media_button" class="button">Select Media</a>
                </p>
                <br>
                <div id="selected_media_preview">
                    <?php
                    if (!empty($_GET['media_id'])) {
                        echo show_media($_GET['media_id']);
                    }
                    ?>
                </div>
                
                <p>
                    <a href="add_admin_avatar.php" class="button">Select Forum Photo</a>
                </p>

                 <!--<li><a href="add_admin_avatar.php">Add Admin Avatar</a></li>-->                
                
                <label style="vertical-align:top;">Details:</label>
                <textarea name="forum_details" id="editor" class="required"></textarea>
                <p class="img_warning">Note: Photo should be no longer than 300 height.</p>
                <script type="text/javascript">
                    // This call can be placed at any point after the
                    // <textarea>, or inside a <head><script> in a
                    // window.onload event handler.
                    // Replace the <textarea id="editor"> with an CKEditor
                    // instance, using default configurations.
                    CKEDITOR.replace('editor');
                </script><br/><br/>
                <input type="hidden" name="media_id" value="<?php echo (!empty($_GET['media_id'])) ? $_GET['media_id'] : ""; ?>"/>
                <input type="submit" name="submit" value="Add Topic" class="button" />
            </form>
        </div>
    </div>
</div>
<?php
include './include/media_selector.php';
?>
<script type="text/javascript">
    if (!String.prototype.trim) {
        String.prototype.trim = function () {
            var c;
            for (var i = 0; i < this.length; i++) {
                c = this.charCodeAt(i);
                if (c == 32 || c == 10 || c == 13 || c == 9 || c == 12)
                    continue;
                else
                    break;
            }
            for (var j = this.length - 1; j >= i; j--) {
                c = this.charCodeAt(j);
                if (c == 32 || c == 10 || c == 13 || c == 9 || c == 12)
                    continue;
                else
                    break;
            }
            return this.substring(i, j + 1);
        };
    }

    $("form").submit(function () {
        var messageLength = CKEDITOR.instances['editor'].getData().replace(/<[^>]*>/gi, '').trim().length;
        if (!messageLength) {
            alert('Please Enter Details To Submit Your Topic!');
            document.getElementById('editor').focus();
            return false;
        }
        return true;
    });
</script>
<?php
include('include/footer.php')
?>
