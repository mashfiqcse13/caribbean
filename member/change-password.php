<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
?>
<?php include('../_includes/header.php'); ?>
<?php
if (isset($_POST['update'])) {
    extract($_POST);
    $error = "";
    if ((isset($password)) && ($password == '')) {
        $error.="Please Enter Old Password";
    }
    if ((isset($newpassword)) && ($password == '')) {
        $error.="Please Enter New Password";
    }
    if ($conframpassword != $newpassword) {
        $error.="Password is not same";
    }
    if ((isset($conframpassword)) && ($conframpassword == '')) {
        $error.="Please Enter Confirm Password";
    }
    if ($error == '') {
        $sql_q = mysql_query("SELECT * FROM  tbl_users WHERE password='" . $_POST['password'] . "' AND id=" . $_SESSION['user_id'] . " AND type='0' ");
        if (mysql_num_rows($sql_q) > 0) {
            $data = array("password" => $_POST['conframpassword']);
            $table = "tbl_users";
            $parameters = "id='" . $_SESSION['user_id'] . "'";
            updateData($data, $table, $parameters);
            $MSG = "<p class='msg'>Password changed sucessfully</p>";
        } else {
            $MSG = "<p class='err'>Old Password Does Not Match Tryagain!</p>";
        }
        $row = mysql_fetch_array($sql_q);
    } else {
        $MSG = "<p class='err'>$error</p>";
    }
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#cng_password').validate({
            rules: {
                newpassword: {
                    required: true,
                    minlength: 7,
                    maxlength: 15
                },
                conframpassword: {
                    required: true, equalTo: "#newpassword"
                }
            },
        });
    });
</script>
<div class="content"><!--START CLASS contant PART -->

    <div id="m_profile"><!--START CLASS m_profile PART -->
        <h1>Change Profile Password</h1>
        <?php
        if (isset($MSG)) {
            echo "<p>" . $MSG . "</p>";
        }
        ?>
        <div id="m_profile_left"><!--START CLASS m_profile_left PART -->
            <ul>
                <li><a href="member.php">Member Area</a></li>
                <li><a href="change-password.php">Change Password</a></li>
                <li><a href="edit-profile.php">Edit Profile</a></li>
                <li><a href="log-out.php">Logout</a></li>
            </ul>

        </div><!--END CLASS m_profile_left PART -->

        <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
            <div class="form_class"><!--START CLASS form_class PART -->


                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="cng_password" >
                    <p><label for="password">Old Password:</label>
                        <input type="password" name="password"  id="password" value=""  class="required" />
                    </p>
                    <p><label for="newpassword">New Password:</label>
                        <input type="password" name="newpassword" maxlength="16" id="newpassword" value=""  class="required" />
                    </p>
                    <p><label for="conframpassword">Confirm Password:</label>
                        <input type="password" name="conframpassword" maxlength="16"  id="conframpassword" value=""  class="required" />
                    </p>
                    <input type="submit" value="update" name="update" class="button"  />

                </form>
            </div><!--END CLASS form_class PART -->		

        </div><!--END CLASS m_profile_right PART -->

    </div><!--END CLASS m_profile PART -->


</div><!--END CLASS contant PART -->


<?php
include('../_includes/footer.php');
?>

