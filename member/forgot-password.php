<?php
include('../_includes/application-top.php');
if ((isset($_POST["send"])) AND ( $_POST["send"] == 'Send Password')) {
    $query = "select * from tbl_users where username='" . mysqli_real_escape_string($link, trim($_POST["username"])) . "' or email ='" . mysqli_real_escape_string($link, trim($_POST["username"])) . "' AND type='0' ";
    $row = mysqli_query($link, $query);
    $row1 = mysqli_num_rows($row);
    $data = mysqli_fetch_assoc($row);
    if ($row1 == 1) {
        $to = $data['email'];
        $subject = SITE_NAME . ": Forget Password Request";
        $msg = "Hi " . $data['first_name'] . " " . $data['last_name'] . " <br />" .
                "Your Username is: " . $data['username'] . "<br> 
                Your Password is: " . $data['password'] . "
                            <br><br>
                            <a href='" . SITE_URL . "member/login.php'>Click here</a> to login to your account.
                            ";
        $from = FROM_EMAIL;
        SendEMail($to, $subject, $msg, $from);
        header("Location: forgot-password.php?status=1"); // User Login details have been send to your registered email address.
        die();
    } else {
        header("Location: forgot-password.php?status=0"); // Invalid Username
        die();
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
    if (isset($_GET['status']) AND ( $_GET['status'] == '1')) {
        echo '<p class="msg">User Login details have been send to your registered email address.</p>';
    } else if (isset($_GET['status']) AND ( $_GET['status'] == '0')) {
        echo '<p class="err">Invalid Username</p>';
    }
    ?>	
    <div class="form_class"><!--START CLASS form_class PART -->

        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="forgot_password">
            <table style="margin: 10px auto 0;">
                <tbody>
                    <tr>
                        <td><label for="username" width="100%" style="width: 175px;">Type Username or Email:</label></td>
                        <td><input name="username" value="" class="required" style="" type="text"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="login.php">Click Here to Login</a></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input name="send" value="Send Password" class="button" style="margin-left: 0px;" type="submit"></td>
                    </tr>
                </tbody>
            </table>							
        </form>
    </div><!--END CLASS form_class PART -->		


</div><!--END CLASS contant PART -->



<?php
include('../_includes/footer.php');
?>