<?php
include('include/application_top.php');
$_SESSION['cms_login'] = 0;
if ((isset($_POST['Login'])) AND ( $_POST['Login'] == 'Login')) {
    $query = "SELECT * FROM tbl_admin_login WHERE name='" . mysqli_real_escape_string( $link ,$_POST['username']) . "' AND password='" . mysqli_real_escape_string( $link ,$_POST['password']) . "'";
    $result = mysqli_query($link,$query);
    $count = mysqli_num_rows($result);
    $data = mysqli_fetch_array($result);
    if ($count == 1) {
        $_SESSION['cms_login'] = 1;
        $_SESSION['cms_id'] = $data['id'];
        $_SESSION['is_admin'] = "yes";
        header("location: caribbean.php");
    } else {
        $msg = "<p style=color:#FF0000;margin-left:130px;>Login Error Please Check</p>";
    }
}
include('include/header.php');
?>

<script type="text/javascript">
    $(document).ready(function () {
        $('#login_check').validate();
    });
</script>
<?php
if (isset($msg) AND ( $msg <> "")) {
    echo "<p>" . $msg . "</p>";
}
?>

<!-- USER LOGIN FORM START HEAR-->
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="login_check">
    <p><label>User Name:</label><input type="text" name="username" value="" class="required" /></p>
    <p><label>Password:</label><input type="password" name="password" value=""  class="required" /></p>
    <p><input type="submit" name="Login" value="Login" /></p>
</form>
<!-- USER LOGIN FORM END HEAR-->
<?php include('include/footer.php'); ?>


