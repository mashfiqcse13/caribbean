<?php
error_reporting(0);
include('include/application_top.php');
include '../_includes/class.database.php';
include '../_includes/class.media.php';
include './include/common_function.php';
include('include/header.php');

$result = mysqli_query($link,"SELECT * FROM tbl_forum_topics WHERE id=" . $_GET["t_id"] . " ");
$rows = mysqli_fetch_assoc($result);
extract($rows);
//$table1="tbl_forum_topics";
//$whereClause="AND id=".$_GET["t_id"]."";
//$result=getAnyTableWhereData($table1,$whereClause);
//extract($result);
//print_r($rows);
//echo $_SESSION['user_id'];
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update Topic')) {

    if ((isset($_POST['forum_details'])) && ($_POST['forum_details'] != '')) {
        $data = array(
            "forum_topic" => mysqli_real_escape_string( $link ,trim($_POST['forum_topic'])),
            "forum_details" => mysqli_real_escape_string( $link ,trim($_POST['forum_details'])),
            "post_date" => date('y-m-d h:i:s'),
            'media_id' => mysqli_real_escape_string( $link ,trim($_POST['media_id']))
        );
        $table = "tbl_forum_topics";
        $parameters = "id='" . $_POST["top_id"] . "'";
        updateData($data, $table, $parameters);
        ?>
        <script type="text/javascript">
            window.location = " <?php echo SITE_URL;?>view_forum_topic_admin.php?id=" + '<?php echo $_POST["top_id"] ?>' + "&op=u";
        </script>
        <?php
        //header("Location:view_forum_topic_admin.php?id=".$_POST["top_id"]."&op=u");
        $MSG = 'Your Topic Update sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Topic !";
    }
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_forum').validate();

    });

</script>


<div class="content" style="margin-left:50px;width:700px">
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
    <p style="text-align:right"><a href="../control/view_forum_topic_admin.php?id=<?php echo $_GET["t_id"]; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p><br/>
    <div class="form_class">
        <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>?t_id=<?php echo $_GET['t_id']; ?>"method="post" id="edit_forum">
            <input type="hidden" name="top_id" value="<?php echo $_GET['t_id']; ?>" />
            <p>
                <label for="email">Topic:</label>
                <input  type="text" name="forum_topic" value="<?php echo $forum_topic; ?>" maxlength="100" class="required" />
            </p>
            <p>
                <a href="#media" id="add_media_button" class="button" style="margin: 0px 0px 0px 132px;">Select Media</a>
            </p>
            <br>
            <div id="selected_media_preview">
                <?php
                if (!empty($media_id)) {
                    echo show_media($media_id);
                }
                ?>
            </div>
            <label style="vertical-align:top;">Details:</label>
            <textarea name="forum_details" id="editor" class="required"><?php echo stripcslashes($forum_details); ?></textarea>
            <script type="text/javascript">
                // This call can be placed at any point after the
                // <textarea>, or inside a <head><script> in a
                // window.onload event handler.
                // Replace the <textarea id="editor"> with an CKEditor
                // instance, using default configurations.
                CKEDITOR.replace('editor',{
                    filebrowserBrowseUrl: '<?php echo SITE_URL1?>control/ckfinder/ckfinder.html',
                    filebrowserImageBrowseUrl: '<?php echo SITE_URL1?>control/ckfinder/ckfinder.html?type=Images',
                    filebrowserFlashBrowseUrl: '<?php echo SITE_URL1?>control/ckfinder/ckfinder.html?type=Flash',
                    filebrowserUploadUrl: '<?php echo SITE_URL1?>control/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                    filebrowserImageUploadUrl: '<?php echo SITE_URL1?>control/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                    filebrowserFlashUploadUrl: '<?php echo SITE_URL1?>control/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                });
                
            </script><br/><br/>
            <input type="hidden" name="media_id" value="<?php echo $media_id ?>"/>
            <input type="submit" name="submit" value="Update Topic" class="button" />   									
        </form>
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
            alert('Please Enter Details To Update Your Topic!');
            document.getElementById('editor').focus();
            return false;
        }
        return true;
    });

</script>
<?php
include('include/footer.php');
?>