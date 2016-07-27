<?php
include('_includes/application-top.php');
CheckLoginForum();

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
            "uid" => $uid,
            "forum_topic" => mysqli_real_escape_string( $link ,trim($_POST['forum_topic'])),
            "forum_details" => mysqli_real_escape_string( $link ,trim($_POST['forum_details'])),
            "post_date" => date('y-m-d h:i:s')
        );
        $table = "tbl_forum_topics";
        $parameters = "id='" . $_POST["top_id"] . "'";
        updateData($data, $table, $parameters);
        header("Location:view_forum_topic.php?id=" . $_POST["top_id"] . "&op=u");
        $MSG = 'Your Topic Update sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Topic !";
    }
}
include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#edit_forum').validate();

    });

</script>


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
    <p style="text-align:right"><a href="view_forum_topic.php?id=<?php echo $_GET["t_id"]; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>
    <div class="form_class">
        <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>?t_id=<?php echo $_GET['t_id']; ?>"method="post" id="edit_forum">
            <input type="hidden" name="top_id" value="<?php echo $_GET['t_id']; ?>" />
            <p>
                <label for="email">Topic:</label>
                <input  type="text" name="forum_topic" value="<?php echo $forum_topic; ?>" maxlength="100" class="required" />
            </p>

            <label style="vertical-align:top;">Details:</label>
            <textarea name="forum_details" id="editor" class="required"><?php echo $forum_details; ?></textarea>
            <script type="text/javascript">
                // This call can be placed at any point after the
                // <textarea>, or inside a <head><script> in a
                // window.onload event handler.
                // Replace the <textarea id="editor"> with an CKEditor
                // instance, using default configurations.
                CKEDITOR.replace('editor');
            </script><br/><br/>
            <input type="submit" name="submit" value="Update Topic" class="button" />   									
        </form>
    </div>
</div>
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
include('_includes/footer.php');
?>