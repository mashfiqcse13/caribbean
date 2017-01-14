<?php
include('../_includes/application-top.php');
if ((isset($_POST["send"])) AND ( $_POST["send"] == 'Send Password')) {
    $query = "select * from tbl_users where (username='" . mysqli_real_escape_string($link, trim($_POST["username"])) . "' "
            . "or email ='" . mysqli_real_escape_string($link, trim($_POST["username"])) . "') AND type='0' ";
    $row = mysqli_query($link, $query);
    $row1 = mysqli_num_rows($row);
    $data = mysqli_fetch_assoc($row);
    
    if(($_POST['captcha_image'] == $_SESSION['captcha_string'])){
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

            $_SESSION['forget_password_status']='1';
            header("Location: member_forget_password.php");  // User Login details have been send to your registered email address.
            die();
        } else {
             $_SESSION['forget_password_status']='0';
             header("Location: member_forget_password.php"); // Invalid Username
            die();
        }
    } 
    else {
        $_SESSION['forget_password_status'] = '2';
        header("Location: member_forget_password.php"); // Invalid Username
        die();
    }
    
    
    
}
?>

<?php include('../_includes/header.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#forget_password').validate();
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Forgot Password</h1>
    <?php 
        if (isset ($_SESSION['forget_password_status']) && $_SESSION['forget_password_status']== '2') {
            echo '<p id="myElem" class="err">Please Enter the correct Captcha</p>';
            $_SESSION['forget_password_status']='';
        }
        else if (isset ($_SESSION['forget_password_status']) && $_SESSION['forget_password_status']== '1') {
            echo '<p id="myElem" class="msg">User Login details have been send to your registered email address.</p>';
            $_SESSION['forget_password_status']='';

        }
        else if (isset ($_SESSION['forget_password_status']) && $_SESSION['forget_password_status']== '0') {

                echo '<p id="myElem" class="err">Invalid Username or Email</p>';
                $_SESSION['forget_password_status']='';
        }
    ?>
    <div class="form_class"><!--START CLASS form_class PART -->

        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="forget_password">
            <table style="margin: 10px auto 0;">
                <tbody>
                    <tr>
                        <td width="100px"><label for="username" width="100%" style="width: 175px;">Type Username or Email:</label></td>
                        <td width="100px"><input name="username" value="" class="required" style="" type="text"></td>
                        <td></td>
                    </tr>
                    
                    
                     <!--captcha code start here-->
                    
                    <tr>  
                        <td width="100px"></td>
                        <td width="100px">
                            
                            <!--anj add javascript-->
                            
                            <a href="javascript:;" title="Reload Image" 
                               onclick="document.getElementById('captcha').src = '../_includes/forget_password_image.php?' + Math.random(); 
                                       return false"> <i class="fa fa-refresh" aria-hidden="true"></i>
                                <img src="../_includes/forget_password_image.php" alt="Enter captcha" title="Enter captcha" id="captcha"/>
                            </a>
                            
                            
                            
                        </td>

                        
                        
                        <!--<td colspan="2" align="right" ><img src="../_includes/forget_password_image.php"></td>-->

                    </tr>
                    <tr>
                         <td width="100px"><label for="captcha" width="100%" style="width: 175px;" >Type The Captcha</label></td>
                         <td width="100px"><input name="captcha_image" value="" class="required" style="" type="text"></td>
                    </tr>
                    
                    
                    <!--captcha code end here-->
                    
                    
                    
                    
                    
                    
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


<!--anj code-->

<script>
    $(document).ready(function(){
           $("#myElem").show().delay(5000).fadeOut();
        });

</script>



<?php
include('../_includes/footer.php');
?>