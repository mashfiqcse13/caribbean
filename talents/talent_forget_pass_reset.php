<?php
include('../_includes/application-top.php');

//security_key_db_reg();
//$data = security_key_check('ac56ff0b054f768c23b235e96def78a4');
//echo var_dump($data);
//die();

    if(isset($_GET['secrate_key']) && security_key_check($_GET['secrate_key'])){
        

        if (isset($_POST['submit']) && ($_POST['submit'] == 'Reset Password')) {
            

            
            if($_POST['new_pass'] == $_POST['re_pass']){
                

                if(($_POST['captcha_image'] == $_SESSION['captcha_string'])){
                    $user_type =1;
                    update_user_password($_POST['user_id'], $_POST['new_pass'], $user_type);
                    
                    security_key_delete($_POST['secrate_key']);
                    
                    $secrate_url = SITE_URL."/talents/login.php?pass_reset_status=4";
                    header("Location: $secrate_url");
                    
                }else{
                    $secrate_url = SITE_URL."/talents/talent_forget_pass_reset.php?uid={$_GET['uid']}&secrate_key={$_GET['secrate_key']}&pass_reset_status=3";
                    header("Location: $secrate_url");
                }
                
            }else{
                $secrate_url = SITE_URL."/talents/talent_forget_pass_reset.php?uid={$_GET['uid']}&secrate_key={$_GET['secrate_key']}&pass_reset_status=2";
                header("Location: $secrate_url");
            }
            
        }
        
        
    }
    else {

        $secrate_url = SITE_URL."/talents/login.php?pass_reset_status=1";
        header("Location: $secrate_url");
        
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
        if (isset($_GET['pass_reset_status']) && $_GET['pass_reset_status']== '3') {
            echo '<p id="myElem" class="err">Please Enter the correct Captcha</p>';

        } else if(isset($_GET['pass_reset_status']) && $_GET['pass_reset_status']== '2'){
            echo '<p id="myElem" class="err">Password do not match</p>';

        }
    ?>



    <div class="form_class">
        <form action="" method="post" id="talents_forget_pass">
            <table style="margin: 10px auto 0;">
                <tbody>
                    <tr>
                        <td><input type="hidden" name="user_id" value="<?php echo $_GET['uid'] ?>"></td>
                        <td><input type="hidden" name="secrate_key" value="<?php echo $_GET['secrate_key'] ?>"></td>

                    </tr>
                    <tr>
                        <td width="100px"><label for="new_pass" width="100%" style="width: 175px;">Type a new password:</label></td>
                        <td width="100px"><input name="new_pass" value="" class="required" style="" type="password"></td>

                    </tr>

                    <tr>
                        <td width="100px"><label for="re_pass" width="100%" style="width: 175px;">Retype the password:</label></td>
                        <td width="100px"><input name="re_pass" value="" class="required" style="" type="password"></td>

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




