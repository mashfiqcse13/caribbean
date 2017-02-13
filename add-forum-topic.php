<?php
include('_includes/application-top.php');
CheckLoginForum();
//echo $_SESSION['user_id'];
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Topic')) {   
    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    
    if ((isset($_POST['forum_details'])) && ($_POST['forum_details'] != '')) {
        $data = array(
            "uid" => $uid,
            "forum_topic" => mysqli_real_escape_string( $link ,trim($_POST['forum_topic'])),
            "forum_details" => mysqli_real_escape_string( $link ,trim($_POST['forum_details'])),
            "view_count" => '0'
        );
        $table = "tbl_forum_topics";
        insertData($data, $table);

        /* Added Activity Below */

        $uname = (GetChatUserName($uid));
        SaveActivity(11, $uname, mysqli_real_escape_string( $link ,trim($_POST['forum_topic'])), $uid);

        //////////////////////////////////////////////////


        $MSG = 'Your Topic Added sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Topic !";
    }
}
include('_includes/header.php');
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
    <p style="text-align:right"><a href="forum.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p><br />
    <div style="width:70%;">
        <div class="form_class">
            <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post" id="add_forum">
                <p>
                    <label for="email">Topic:</label>
                    <input  type="text" name="forum_topic" value="" maxlength="100" class="required" />
                </p>

                <label style="vertical-align:top;">Details:</label>
                <textarea name="forum_details" id="editor" class="required"></textarea>
                <script type="text/javascript">
                    // This call can be placed at any point after the
                    // <textarea>, or inside a <head><script> in a
                    // window.onload event handler.
                    // Replace the <textarea id="editor"> with an CKEditor
                    // instance, using default configurations.
                    CKEDITOR.replace('editor');
                </script><br/><br/>
                <input type="submit" name="submit" value="Add Topic" class="button" />   									
            </form>
        </div>
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
            alert('Please Enter Details To Submit Your Topic!');
            document.getElementById('editor').focus();
            return false;
        }
        return true;
    });

</script>
<?php
include('_includes/footer.php');
?>