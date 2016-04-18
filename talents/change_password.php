<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if (isset($_POST['submit'])) {
    extract($_POST);
    $error = "";

    if ((isset($password)) && ($password == '')) {
        $error.="Please Enter Old Password";
    }

    if ((isset($newpassword)) && ($newpassword == '')) {
        $error.="Please Enter New Password";
    }
    if ($conframpassword != $newpassword) {
        $error.="Newpassword and confirmation password do not match. Please type more carefully!";
    }

    if ((isset($conframpassword)) && ($conframpassword == '')) {
        $error.="Please Enter Confirm Password";
    }
    if ($error == '') {
        //echo "select * from reg_form where password='" .$_POST['password']."' AND id=".$_SESSION['user_id']."";
        $sql_q = mysql_query("SELECT * FROM tbl_users WHERE password='" . mysql_real_escape_string(trim($_POST['password'])) . "' AND id=" . $_SESSION['talent_id'] . " ");

        if (mysql_num_rows($sql_q) > 0) {
            $sql = "UPDATE tbl_users SET password='" . mysql_real_escape_string(trim($_POST['conframpassword'])) . "' WHERE id=" . $_SESSION['talent_id'] . " ";
            $rs = mysql_query($sql);

            $MSG1 = "Password changed sucessfully.";


            //header("Location:login.php?msg=successful");	
        } else {
            $MSG = "Old Password Does Not Match Try again!";
        }
        $row = mysql_fetch_array($sql_q);
        //print_r($row);
    } else {
        $error;
    }
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#valid_pass_form').validate({
            rules: {
                newpassword: {
                    required: true, minlength: 7, maxlength: 15
                },
                conframpassword: {
                    required: true, equalTo: "#newpassword"
                },
            },
        });
    });

    function back()
    {
        window.history.back();
    }
</script>
<div class="content">
    <h1>Change Profile Password</h1>

    <p style="text-align:right"><a href="member.php" class="button" style="float:left; margin:-5px 0px 5px 0px;" >Back</a></p><div class="form_class">
        <?php
        if ((isset($MSG1)) || (isset($MSG)) || (isset($error))) {
            ?>
            <p class="err">
                <?php
                if (isset($error) AND ( $error <> "")) {
                    echo $error;
                }
                if (isset($MSG) AND ( $MSG <> "")) {
                    echo $MSG;
                }
                ?>     
            </p>
            <p class="msg">
                <?php
                if (isset($MSG1) AND ( $MSG1 <> "")) {
                    echo $MSG1;
                }
                ?>
            </p>
        <?php } ?>

        <div id="m_profile">
            <div id="m_profile_left">
                <ul>
                    <li><a href="change_password.php">Change Password</a></li>
                    <li><a href="edit_profile.php">Edit Profile</a></li>
                    <li><a href="profile_setup.php">Profile Setup</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <div class="form_class"><!--START CLASS form_class PART -->
                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="valid_pass_form">
                        <input type="hidden" name="id" value="<?php echo $_SESSION['talent_id']; ?>" />
                        <p>
                            <label>Old Password:</label>
                            <input type="password" name="password" maxlength="30" value="" id="password" class="required" size="30"/>
                        </p>  
                        <p>
                            <label>New Password:</label>
                            <input type="password" name="newpassword" maxlength="16" value=""  id="newpassword" class="required" size="30"/>
                        </p>
                        <p>
                            <label>Confirm Password:</label>
                            <input type="password" name="conframpassword" maxlength="16" value="" id="conframpassword" class="required" size="30"/>
                        </p>
                        <input  type="submit" name="submit" value="Change Password" class="button"   />          
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../_includes/footer.php');
?>
