<?php
include('_includes/application-top.php');
CheckLoginForum();
//echo $_SESSION['talent_id'];
$sql = mysql_query("SELECT * FROM tbl_forum_topics WHERE id='" . $_GET['id'] . "'");
$ruselt = mysql_fetch_assoc($sql);
//print_r($ruselt);

if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Submit Reply')) {
    /* if(isset($_SESSION["talent_id"])){
      $uid=$_SESSION["talent_id"];
      }else if(isset($_SESSION["user_id"])){
      $uid=$_SESSION["user_id"];
      } */
    if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
        $uid = $_SESSION['talent_id'];
    } elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
        $uid = $_SESSION['user_id'];
    } else {
        $uid = "";
    }

    if ((isset($_POST['forum_reply'])) && ($_POST['forum_reply'] != '')) {
        $data = array(
            "forum_id" => $_GET['id'],
            "uid" => $uid,
            "reply_text" => mysql_real_escape_string(trim($_POST['forum_reply'])),
        );
        $table = "tbl_forum_reply";
        insertData($data, $table);

        /* Added Activity Below */

        $uname = (GetChatUserName($uid));
        SaveActivity(12, $uname, $ruselt['forum_topic'], $uid);

        //////////////////////////////////////////////////
        $MSG = 'Your Reply Added sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Reply!";
    }
}
include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#comment').validate();
    });
</script>
<div class="content">
    <h1>Your Reply</h1>
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
    <p style="text-align:right"><a href="view_forum_topic.php?id=<?php echo $_GET['id']; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p><br />
    <div style="width:70%;">
        <div class="form_class">
            <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="comment">											
                <p><label>Reply:</label></p>	
                <textarea name="forum_reply" id="editor" class="required"></textarea>
                <script type="text/javascript">
                    // This call can be placed at any point after the
                    // <textarea>, or inside a <head><script> in a
                    // window.onload event handler.
                    // Replace the <textarea id="editor"> with an CKEditor
                    // instance, using default configurations.
                    CKEDITOR.replace('editor');
                </script><br/><br/>					
                <input type="submit" name="submit" value="Submit Reply" class="button" />
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
            alert('Please Enter Details To Submit Your Reply!');
            document.getElementById('editor').focus();
            return false;
        }
        return true;
    });

</script>
<?php
include('_includes/footer.php');
?>

