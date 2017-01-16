<?php
include('../_includes/application-top.php');
include('../_includes/header.php');

if (isset($_POST['submit']) && $_POST['submit'] == 'Reset Password') {
    if (security_key_check($_GET['secrate_key'])) {
        $secrate_key_check_result = 1;
        $user_type=1;
        update_user_password($_GET['uid'], $_POST['new_pass'], $user_type);
        
    } else {
        $secrate_key_check_result = 0;
    }
}
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_forget_pass').validate();
    });
</script>


<div class="content">
    <h1>Reset Your Password</h1>

<?php
if ($secrate_key_check_result == 1) {
    echo '<p id="myElem" class="msg">Your Password Reset Succefully</p>';
    $_SESSION['secrate_key_check'] = '';
} else {
    echo '<p id="myElem" class="err">The link is expired.</p>';
    $_SESSION['secrate_key_check'] = '';
}
?>



    <div class="form_class">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="talents_forget_pass">
            <table style="margin: 10px auto 0;">
                <tbody>
                    <tr>
                        <td width="100px"><label for="new_pass" width="100%" style="width: 175px;">Type a new password:</label></td>
                        <td width="100px"><input name="new_pass" value="" class="required" style="" type="text"></td>

                    </tr>

                    <tr>
                        <td width="100px"><label for="re_pass" width="100%" style="width: 175px;">Retype the password:</label></td>
                        <td width="100px"><input name="re_pass" value="" class="required" style="" type="text"></td>

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
                        <td width="100px"></td>
                        <td width="100px"><a href="login.php">Click Here to Login</a></td>
                    </tr>
                    <tr>
                        <td width="100px"></td>
                        <td width="100px"><input name="submit" value="Reset Password" class="button" style="margin-left: 0px;" type="submit"></td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>

<!--anj code-->

<script>
    $(document).ready(function () {
        $("#myElem").show().delay(5000).fadeOut();
    });

</script>


<?php
include('../_includes/footer.php');
?>




