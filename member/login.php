<?php
include('../_includes/application-top.php');
$_SESSION['user_login'] = 0;

$lid = @$_REQUEST['lid'];
if (!empty($lid)) {
    $_SESSION['user_login'] = 1;
    $_SESSION['user_id'] = $lid;

    $data = array(
        "user_id" => $_SESSION['user_id'],
        "biography" => " ",
        "profile_display_status" => "1"
    );
    $table = "tbl_user_details";
    insertData($data, $table);

    /* Added Activity Below */
    SaveActivity(14, mysqli_real_escape_string( $link ,trim($_POST['username'])), '', $l_id);

    //////////////////////////////////////////////////
}


if ((isset($_POST['login'])) AND ( $_POST['login'] == 'Sign In')) {
    $query = "SELECT * FROM tbl_users WHERE email='" . mysqli_real_escape_string( $link ,trim($_POST["username"])) . "' AND password='" . mysqli_real_escape_string( $link ,trim($_POST["password"])) . "' AND type='0' AND `is_block_admin` = 'No' AND (suspend_to < '" . date("Y-m-d H:i:s") . "' OR suspend_to IS NULL)";
//$query="SELECT * FROM tbl_users WHERE username='".mysqli_real_escape_string( $link ,trim($_POST["username"]))."' AND password='".$_POST["password"]."' AND type='0'";
    $result = mysqli_query($link,$query);
    $count = mysqli_num_rows($result);
    $data = mysqli_fetch_array($result);
    if ($count == 1) {
        //First Destroy All Previous Session then continue/
        session_destroy();
        session_start();
        $_SESSION['user_login'] = 1;
        $_SESSION['user_id'] = $data['id'];
        header("Location:member.php");
    } else {
        $MSG = "Invalid Email or Password, Please try again";
    }
}
?>
<?php include('../_includes/header.php'); ?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#non_talents_log').validate({
            rules: {
                password: {
                    required: true
                },
            },
        });
    });
</script>


<div class="content"><!--DIV START content-->

    <h1>Member Login</h1>

    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
        echo "<p class='msg'>Congratulations, Your account has been created succefully.</p>";
    }
    ?>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='err'>" . $MSG . "</p>";
    }
    ?>
    <?php
    //CHECK USER LOGIN ALREADY EXIST OR NOT
    if (isset($_GET['op']) AND ( $_GET['op'] == "invalid")) {
        echo "<p class='err'>Invalid Login </p>";
    }
    ?>
    <div class="form_class"><!--DIV START form_class-->
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="non_talents_log">
            <p>
                <label for="username">Email:</label>
                <input type="text" name="username" value="" maxlength="30" class="required" />

            </p>
            <p>
                <label for="password">Password:</label>
                <input type="password" name="password" value="" maxlength="10" class="required"/>

            </p>
            <input type="submit" name="login" id="button" value="Sign In"  class="button" />
        </form>
    </div><!--DIV END form_class-->
    <p>Not a member&nbsp;?&nbsp;<a href="registration.php">Click Here</a>&nbsp;to Register.</p>
    <p>Forgot Your Password&nbsp;?&nbsp;<a href="forgot-password.php">Click Here</a></p>
</div><!--DIV END content-->

<?php include('../_includes/footer.php'); ?>


