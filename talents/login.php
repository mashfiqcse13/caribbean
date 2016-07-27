<?php
include('../_includes/application-top.php');

$lid = @$_REQUEST['lid'];

if (!empty($lid)) {

////////tbl_user_details INSERTED/////////
    $data = array(
        "user_id" => $lid,
        "biography" => " ",
        "profile_display_status" => "1"
    );
    $table = "tbl_user_details";
    insertData($data, $table);
    /* Added Activity Below */
    SaveActivity(14, mysqli_real_escape_string( $link ,trim($_POST['username'])), '', $lid);
    //////////////////////////////////////////////////
}


// $time=strtotime(date('Y-m-d h:i:s'));
//exit();
$_SESSION['talent_login'] = 0;
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Sign In')) {

    $count = strlen(trim($_POST["username"]));


    $query = "select * from tbl_users where email='" . mysqli_real_escape_string( $link ,trim($_POST["username"])) . "'AND password='" . mysqli_real_escape_string( $link ,trim($_POST["password"])) . "'AND type='1' AND `is_block_admin` = 'No' AND (suspend_to < '" . date("Y-m-d H:i:s") . "' OR suspend_to IS NULL)";
    $row = mysqli_query($link,$query);
    $row1 = mysqli_num_rows($row);
    $data = mysqli_fetch_array($row);
    if ($row1 == 1) {
        //First Destroy All Previous Session then continue/
        //session_destroy();
        session_start();
        //$_SESSION['admin_login']=1;
        $_SESSION['talent_login'] = 1;
        $_SESSION['talent_id'] = $data['id'];
        header("Location:member.php");
        //echo "successful";
    } else {
        //when login not successfull if block then show block, suspend message.
        $row_two = mysqli_fetch_array(mysqli_query($link,"select * from tbl_users where email='" . mysqli_real_escape_string( $link ,trim($_POST["username"])) . "'AND password='" . mysqli_real_escape_string( $link ,trim($_POST["password"])) . "'"));
        if (!empty($row_two['is_block_admin']) && $row_two['is_block_admin'] == "Yes") {
            $MSG = "Your Account is Temporary Blocked by Admin!";
        } else if (!empty($row_two['suspend_to']) && $row_two['suspend_to'] > date("Y-m-d H:i:s")) {
            $MSG = "Your Account is Temporary Suspend by Admin!";
        } else {
            $MSG = "Invalid Email or Password, Please Try again!";
        }
    }
}

include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_loin').validate({
            rules: {
                username: {
                    required: true, minlength: 2, maxlength: 30
                },
                password: {
                    required: true, minlength: 2, maxlength: 30
                },
            },
        });
        $("#username").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57) && (e.which < 65 || e.which > 90) && (e.which < 97 || e.which > 122))
            {
                return false;
            }
        });
    });
</script>
<div class="content">
    <h1>Talents Login</h1>

    <p class="msg"> <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "register")) {
            // echo "Congratulations, Your account has been created succefully.";
            echo "You have been Successfully Verified.";
        }
        ?></p>
    <?php
    if ((isset($MSG1)) || (isset($MSG))) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
    <?php } ?>
    <div class="form_class">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" id="talents_loin">
            <p>
                <label for="username">Email:</label>
                <input type="text" name="username" id="username" value="" maxlength="30" class="required" />
            </p>
            <p>
                <label for="username">Password:</label>
                <input type="password" name="password" id="password" value="" maxlength="30" class="required" size="30" />
            </p>
            <input type="submit" name="submit" value="Sign In" class="button" />
        </form>
        <p>Not a member ? <a href="registration.php">Click Here</a> to Register.</p>
        <p>Forget Your Password ? <a href="forget_password.php">Click Here</a>.</p>
    </div> 
</div>
<?php
include('../_includes/footer.php');
?>
