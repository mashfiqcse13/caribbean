<?php
include('../_includes/application-top.php');
if ((isset($_POST["send"])) AND ( $_POST["send"] == 'Send Password')) {
    $query = "SELECT * FROM tbl_users WHERE username='" . mysqli_real_escape_string( $link ,trim($_POST["username"])) . "' AND type='0'";
    $row = mysqli_query($link,$query);
    $row1 = mysqli_num_rows($row);
    $data = mysqli_fetch_assoc($row);
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
?>

<?php include('../_includes/header.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#forgot_password').validate();
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Forgot Password</h1>

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
    <p style="text-align:right"><a href="login.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>	
    <div class="form_class"><!--START CLASS form_class PART -->

        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="forgot_password">
            <p >
                <label for="username" style="width:200px;">Type Username:</label>
                <input type="text" name="username" value="" class="required"/>
            </p>	
            <input type="submit" name="send" value="Send Password" class="button" style="margin-left:200px;"/>								
        </form>
    </div><!--END CLASS form_class PART -->		


</div><!--END CLASS contant PART -->



<?php
include('../_includes/footer.php');
?>