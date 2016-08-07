<?php
include('include/application_top.php');
cmslogin();
include('include/header.php');
?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url, action) { //confarming property delete
        if (confirm("Are you sure you want to " + action + " this profile?")) {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
</script>
<?php
$query = "SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'";
$query_row = mysqli_query($link,$query);
$data = mysqli_fetch_array($query_row);
$_SESSION['ab'] = $data['first_name'];

if (!empty($_REQUEST['task'])) {
    ?>
    <p style="text-align: center;padding: 10px;color: #ffffff;background: green;">
        <span >
            <?php
            switch ($_REQUEST['task']) {
                case "suspend": echo "This account has been Successfully Suspended.";
                    break;
                case "block": echo "This account has been Successfully Blocked.";
                    break;
                case "unblock": echo "This account has been Successfully UnBlocked.";
                    break;
            }
            ?>
        </span>
    </p>
<?php } ?>
<br/>
<ul>
    <li class="b_image" style="height:152px;border: 0;">
    <!-- <img src="../_uploads/user_photo/<?php echo $data["id"]; ?>.jpg" height='150' width='120'/> -->
        <?php
        $image = "../_uploads/user_photo/" . $data["id"] . ".jpg";
        if (file_exists($image)) {
            ?>
            <img src="<?php echo $image . "?" . time(); ?>"width='120'/>
        <?php } else { ?>
            <img src="images/dummy.png" width='120'/>
        <?php } ?>
    </li>
</ul>
<br />

<p style="margin-left:200px; width:600px;  ">
    <label>Name:</label> <?php echo $data['first_name'] . " " . $data['last_name']; ?>
</p>

<p style="margin-left:200px; width:600px;  ">
    <label>Username:</label> <?php echo $data['username']; ?>
</p>

<p style="margin-left:200px; width:600px;  ">
    <label>Password:</label><?php echo $data['password']; ?>
</p>

<p style="margin-left:200px; width:600px;  ">
    <label>Phone No:</label> <?php echo $data['phone_no']; ?>
</p>

<p style="margin-left:200px; width:600px;<?php if ($data['new_mac_req'] == 1) { ?> color:#FF0000; font-weight:bold; <?php } ?>">
    <label>Mac Address:</label>
    <?php echo $data['mac_address']; ?>&nbsp;&nbsp;&nbsp;
    Allowed: <select name="mac_alwd" id="mac_alwd">
        <?php for ($i = 1; $i <= 10; $i++) { ?>
            <option value="<?php echo $i; ?>" <?php echo $i == $data['allowed_mac'] ? 'selected="selected"' : ''; ?>><?php echo $i; ?></option>
        <?php } ?>  
    </select>&nbsp;&nbsp;
    <input type="button" value="Go" class="button3" style="float:none;background-color: green;border-radius: 5px;" onclick="change_mac('<?php echo $data['mac_address']; ?>');" />
</p>

<?php
if ($data['new_mac_req'] == 1) {
    $myqry2 = mysqli_query($link,"SELECT * FROM tbl_users WHERE mac_address='" . $data['mac_address'] . "'");
    ?>
    <p style="margin-left:200px; width:600px;"><label>Connected Users:</label>
        <?php
        while ($each1 = mysqli_fetch_assoc($myqry2)) {
            echo $each1['first_name'] . " " . $each1['last_name'] . ", ";
        }
        ?>
    </p>
<?php } ?>

<p style="margin-left:200px; width:600px;  ">
    <label>Email:</label> <?php echo $data['email']; ?>
</p>

<p style="margin-left:200px; width:600px; ">
    <label>City:</label> <?php echo $data['city']; ?>
</p>

<p style="margin-left:200px; width:600px; ">
    <label>Type:</label> <?php echo $data['type'] == 1 ? "Talent" : "Member"; ?>
    <?php /* ?> <?php echo $data['type'];?><?php */ ?>
</p>
<p style="margin-left:200px; width:600px; ">
    <label>Account Status:</label> 
    <?php
    echo $data['is_block_admin'] == "Yes" ? "Blocked" : '';
    echo date("Y-m-d H:i:s") < $data['suspend_to'] ? ("Suspended Till :" . date('Y-m-d', strtotime($data['suspend_to']))) : '';
    //echo $data['status_note'] !='' ? ('( ' . $data['status_note'] . ' )') : '';
    ?>
</p>

<?php
if ($data['type'] == 1) {
    //session_start();
    $_SESSION['talent_login'] = 0;
    $session_query = "SELECT * FROM tbl_users WHERE username='" . $data['username'] . "' AND password='" . $data['password'] . "' AND type='1'";
    $result = mysqli_query($link,$session_query);
    $count = mysqli_num_rows($result);
    $data_1 = mysqli_fetch_array($result);
    if ($count == 1) {
        $_SESSION['talent_login'] = 1;
        $_SESSION['talent_id'] = $data_1['id'];
        /* header("Location:member.php");
          } */
        ?>
        <form method="post" action="account_suspend.php" name="form_status">
            <p style="margin-left:200px; width:600px; ">
                <label>Change Status:</label>
                <select name="change_status" id="" onchange="check_suspend(this)">
                    <option value="">--Select--</option>
                    <option value="suspend">Suspend</option>
                    <option value="unsuspend">Unsuspend</option>
                    <option value="block">Block</option>
                    <option value="unblock">UnBlocke</option>
                </select>
                <span id="sus_date"></span><br/><br/>
                <input type="hidden" name="id" value="<?php echo $data_1['id']; ?>">
                <input type="hidden" name="url_back" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="submit" name="status_btn" value="Change Status" class="button3" style="float:none;background-color: green;border-radius: 5px;">
            </p>
        </form>
        <p style="margin-left:200px; width:600px; ">
            <a href="<?php echo SITE_URL2; ?>talents/member.php?id=<?php echo $_REQUEST['id'] ?>" target="_blank" style="color:#009900;border-bottom:1px solid #993300;">Go to member area</a>
            <a href="../profile-details.php?username=<?php echo $data_1['username']; ?>" target="_blank" style="color:#daa520;font-weight:bold;border-bottom:1px solid #993300;">View Public Profile</a>
        </p>
        <hr />
        <p class="delete_user_account">
            If you want to permanently delete this account, then please click the link below. once deleted every thing relating to this account will be removed form the site immediately. this can't be undone so proceed at your own risk.
        </p>

        <a href="<?php echo "javascript:ConfrimMessage_Delete('delete_account.php?id=$data_1[id]', 'Delete')"; ?>">
            <div class="button2">Delete this Account</div>
        </a>
        <!--<a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=suspend', 'Suspend')"; */ ?>"><div class="button3">Suspend this Account</div></a>
        <a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=block', 'Block')"; */ ?>"><div class="button3">Block this Account</div></a>
        <a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=unblock', 'Unblock')"; */ ?>"><div class="button3">UnBlock this Account</div></a>-->

        <?php
    }
} else {
    $_SESSION['user_login'] = 0;
    $session_query = "SELECT * FROM tbl_users WHERE username='" . $data['username'] . "' AND password='" . $data['password'] . "' AND type='0'";
    $result = mysqli_query($link,$session_query);
    $count = mysqli_num_rows($result);
    $data_1 = mysqli_fetch_array($result);
    if ($count == 1) {
        $_SESSION['user_login'] = 1;
        $_SESSION['user_id'] = $data_1['id'];
        ?>
        <form method="post" action="account_suspend.php" name="form_status">
            <p style="margin-left:200px; width:600px; ">
                <label>Change Status:</label>
                <select name="change_status" id="" onchange="check_suspend(this)">
                    <option value="">--Select--</option>
                    <option value="suspend">Suspend</option>
                    <option value="unsuspend">Unsuspend</option>
                    <option value="block">Block</option>
                    <option value="unblock">UnBlock</option>
                </select>
                <span id="sus_date"></span><br/><br/>
                <input type="hidden" name="id" value="<?php echo $data_1['id']; ?>">
                <input type="hidden" name="url_back" value="<?php echo $_SERVER['REQUEST_URI']; ?>">
                <input type="submit" name="status_btn" value="Change Status" class="button3" style="float:none;background-color: green;border-radius: 5px;">
            </p>
        </form>
        <p style="margin-left:200px; width:600px; "> 
            <a href="<?php echo SITE_URL2; ?>member/member.php?id=<?php echo $_REQUEST['id'] ?>" target="_blank" style="color:#009900;border-bottom:1px solid #993300;">Go to member area</a>
            <a href="../profile-details.php?username=<?php echo $data_1['username']; ?>" target="_blank" style="color:#daa520;font-weight:bold;border-bottom:1px solid #993300;">View Public Profile</a>
        </p>
        <hr />

        <p class="delete_user_account">
            If you want to permanently delete this account, then please click the link below. once deleted every thing relating to this account will be removed form the site immediately. this can't be undone so proceed at your own risk.
        </p>

        <a href="<?php echo "javascript:ConfrimMessage_Delete('delete_account.php?id=$data_1[id]', 'Delete')"; ?>">
            <div class="button2">Delete this Account</div>
        </a>
        <!--<a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=suspend', 'Suspend')"; */ ?>"><div class="button3">Suspend this Account</div></a>
        <a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=block', 'Block')"; */ ?>"><div class="button3">Block this Account</div></a>
        <a href="<?php /* echo "javascript:ConfrimMessage_Delete('account_suspend.php?id=$data_1[id]&action=unblock', 'Unblock')"; */ ?>"><div class="button3">UnBlock this Account</div></a>-->
        <?php
    }
}
?>
<script type="text/javascript">
    function check_suspend(obj) {
        if (obj.value == "suspend") {
            $("#sus_date").html("<input type='text' style='border: 1px solid red;width:60px;' name='suspend_days' placeholder='Enter Days'>eg:5");
        } else {
            $("#sus_date").html("");
        }
        if (obj.value == 'suspend' || obj.value == 'block') {
            $("#sus_date").append("<input type='text' style='margin-left:10px;width:200px;' name='status_note' placeholder='Enter note ...'>");
        }
        ;
    }

    function change_mac(mid) {
        if (mid != '') {
            $.post('mac-ajax.php', {mac_cntr: $('#mac_alwd').val(), mac_adr: mid})
                    .done(function (data) {
                        //alert(data);
                        window.location.reload();
                    });//
        } else {
            alert('No Mac address registered');
        }
    }
</script>

<?php include('include/footer.php'); ?>
