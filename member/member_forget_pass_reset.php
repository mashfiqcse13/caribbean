<?php
include('../_includes/application-top.php');

//security_key_db_reg();
//$data = security_key_check('ac56ff0b054f768c23b235e96def78a4');
//echo var_dump($data);
//die();

  
if (isset($_POST['submit']) && $_POST['submit'] == 'Reset_Password') {
    
    if(($_POST['captcha_image'] == $_SESSION['captcha_string'])){
    
        if(security_key_check($_POST['secrate_key'])){
            $user_type =0;
            update_user_password($_POST['user_id'], $_POST['new_pass'], $user_type);
            $secrate_key_check_result = 1;
        }
        else{
            $secrate_key_check_result=2;

        }

//        echo $_POST['user_id']; 
//        echo $_POST['secrate_key']; 
    
    }
    else{
        $secrate_key_check_result=3;
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
    <h1>Reset Your Password</h1>

    <?php
if ($secrate_key_check_result == 1) {
    echo '<p id="myElem" class="msg">Your Password Reset Succefully</p>';
    
} else if($secrate_key_check_result == 2){
    echo '<p id="myElem" class="err">The link is expired.</p>';

}else if($secrate_key_check_result==3){
    echo '<p id="myElem" class="err">Please Enter the correct Captcha</p>';
}
    ?>



    <div class="form_class">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="talents_forget_pass">
            <table style="margin: 10px auto 0;">
                <tbody>
                    <tr>
                        <td><input type="hidden" name="user_id" value="<?php echo $_GET['uid'] ?>"></td>
                        <td><input type="hidden" name="secrate_key" value="<?php echo $_GET['secrate_key'] ?>"></td>

                    </tr>
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
                        <td width="100px"><input name="submit" value="Reset_Password" class="button" style="margin-left: 0px;" type="submit"></td>
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




