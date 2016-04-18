<?php
include('_includes/application-top.php');
CheckLoginForum();

if (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
    $identity = $_SESSION['talent_id'];
} elseif (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
    $identity = $_SESSION['user_id'];
} else {
    $identity = "";
}

if ((isset($_POST['submit'])) && ($_POST['submit'] == "Send")) {
    $data = array(
        "from_id" => $identity,
        "to_id" => $_POST['to_id'],
        "sub" => mysql_real_escape_string(trim($_POST['sub'])),
        "msg" => mysql_real_escape_string(trim($_POST['msg'])),
        "view_status" => '0'
    );

    $table = "tbl_msg";
    insertData($data, $table);

    $MSG = "MESSAGE SEND SUCCESSFULLY";

    //header("location:send_msg.php?id=".$_POST['to_id']);
}
include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#message').validate()
    });

</script>
<div class="content"><!--START CLASS contant PART -->
    <?php
    if (((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"] == 0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"] == 0)) || ($_SESSION["is_admin"] == "yes")) {
//if((!isset($_SESSION["talent_id"]) || ($_SESSION["talent_id"]==0)) && (!isset($_SESSION["user_id"]) || $_SESSION["user_id"]==0)){
        ?>
        <p class="err">Please Login First</p>
        <?php
    } else {
        ?>
        <?php
        $query = "SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'";
        $query_row = mysql_query($query);
        $data1 = mysql_fetch_array($query_row);
        ?>
        <h2>Send message to <?php echo $data1['first_name'] . " " . $data1['last_name']; ?></h2>	
        <?php
        if (isset($MSG) AND ( $MSG <> "")) {
            echo "<p class='msg'>$MSG</p>";
        }
        ?>

        <div class="form_class"><!--START CLASS form_class PART -->
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>?id=<?php echo $data1['id']; ?>" method="post" id="message" name="message">

                <p><label for="sub">Subject:</label>

                    <input type="text" name="sub" value="" class="required" />

                </p>

                <p><label for="msg">Message:</label>
                    <textarea name="msg" style="height:100px; width:300px;" class="required"></textarea>
                </p>
                <input type="hidden" name="to_id" value="<?php echo $data1['id']; ?>" />

                <input type="submit" name="submit" value="Send" class="button" />

            </form>

        </div><!--END CLASS form_class PART -->
    <?php } ?>
</div><!--END CLASS contant PART -->
<?php
include('_includes/footer.php');
?>