<?php
include('../_includes/application-top.php');
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Send Email')) {
    $query = "select * from tbl_users where username='" . mysqli_real_escape_string( $link ,trim($_POST["username"])) . "' AND type='1' ";
    $row = mysqli_query($link,$query);
    $row1 = mysqli_num_rows($row);
    $data = mysqli_fetch_assoc($row);
    //print_r($data);
    if ($row1 == 1) {
        $to = $data['email'];
        $subject = SITE_NAME . ": Forget Password Request";
        $msg = "Hi " . $data['first_name'] . " " . $data['last_name'] . " <br />" .
                "Your Username is: " . $data['username'] . "<br> 
						     Your Password is: " . $data['password'] . "
								 <br><br>
								 <a href='" . SITE_URL . "'>Click here</a> to login to your account.
								 ";
        $from = FROM_EMAIL;
        //SendEMail($to,$subject,$msg,$from);  
        $MSG = "User Login details have been send to your registered email address.";
    } else {
        $MSG1 = "Invalid Username";
    }
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_forget_pass').validate();
    });
</script>
<div class="content">
    <h1>Password Search</h1>
    <?php
    if ((isset($MSG1)) || (isset($MSG))) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
        <p class="msg">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
        </p>
        <?php
    }
    ?>
    <div class="form_class">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="talents_forget_pass">
            <p>
                <label for="username">Type Username:</label>
                <input type="text" name="username" value="" class="required" style="margin-left:30px;"/>
            </p>
            <input type="submit" name="submit" value="Send Email" class="button" style="margin-left:168px;" />
        </form>
    </div>
</div>
<?php
include('../_includes/footer.php');
?>
