<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>
<?php
if (isset($_POST['submit'])) {
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
        /* PASSWORD CHANGE START HEAR */
        $sql_q = mysqli_query($link,"SELECT * FROM tbl_admin_login WHERE password='" . $_POST['password'] . "' AND id=" . $_SESSION['cms_id'] . " ");
        if (mysqli_num_rows($sql_q) > 0) {
            $data = array("password" => $_POST['conframpassword']);
            $table = "tbl_admin_login";
            $parameters = "id='" . $_SESSION['cms_id'] . "'";
            updateData($data, $table, $parameters);
            echo "<p style=color:#FF9900;margin-left:25px;>Password changed Successfully!</p>";
        } else {
            echo"<p style=color:#FF0000;margin-left:25px;>Old Password Does Not Match Tryagain!</p>";
        }
        $row = mysqli_fetch_array($sql_q);
    } else {
        echo "<p style=color:#FF0000;margin-left:60px;>$error</p>";
    }
}
?>	
<script type="text/javascript">
    $(document).ready(function () {
        $('#c_password').validate({
            rules: {
                newpassword: {
                    required: true
                },
                conframpassword: {
                    required: true, equalTo: "#newpassword"
                },
            },
        });
    });
</script>
<div id="cg_password">
    <h2>PASSWORD CHANGE</h2>
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="c_password" >
        <p><label>Old Password:</label><input type="password" name="password" id="password" value="" class="required"/></p>
        <p><label>New Password:</label><input type="password" name="newpassword" id="newpassword" value="" class="required"/></p>
        <p><label>Confirm Password:</label><input type="password" name="conframpassword" id="conframpassword" value="" class="required"/></p>
        <input type="submit" value="submit" name="submit" />
    </form>
</div>



<?php include('include/footer.php'); ?>

