<?php
include('../_includes/application-top.php');
if (isset($_REQUEST['lid'])) {
    $lid = $_REQUEST['lid'];
}
$_SESSION['talent_login'] = 1;

if (!empty($lid)) {
    $_SESSION['talent_id'] = $lid;
    ////////tbl_user_details INSERTED/////////
    $data = array(
        "user_id" => $_SESSION['talent_id'],
        "biography" => " ",
        "profile_display_status" => "1"
    );
    $table = "tbl_user_details";
    insertData($data, $table);
    /* Added Activity Below */
    SaveActivity(14, mysqli_real_escape_string( $link ,trim($_POST['username'])), '', $lid);
    //////////////////////////////////////////////////
}

ChecktalentLogin();

function talent($id) {
    global $link;
    $sql = "SELECT * FROM tbl_talents WHERE status=1 AND id='" . $id . "'";
    $result = mysqli_query($link,$sql);
    $data = mysqli_fetch_assoc($result);
    return $data['talent'];
}

//echo $_SESSION['talent_id'];
$result = "SELECT * FROM tbl_users WHERE id='" . $_SESSION['talent_id'] . "'";
$sql = mysqli_query($link,$result);
$data = mysqli_fetch_assoc($sql);
//print_r($data);
include('../_includes/header.php');
?>
<div class="content">
    <h1>Your profile</h1>
    <?php
    if (isset($_GET['op'])) {
        ?>	
        <p class="msg">
            <?php
            // if(isset($_GET['op']) AND ($_GET['op']=="register")){
            //         // echo "Congratulations, Your account has been created succefully.";
            //          echo "You have been Successfully Verified.";
            //        }
            ?>

            <?php
            switch (strtolower($_GET['op'])) {
                case "u": echo "Welcome Your Photo update sucessfully.";
                    break;
                case "add": echo "Welcome Your Payment Details Added sucessfully.";
                    break;
                case "up": echo "Welcome Your Payment Details update sucessfully.";
                    break;
                case "a": echo "Welcome Your Photo upload sucessfully.";
                    break;
            }
            ?>
        </p>
    <?php } ?>
    <div class="form_class">
        <div id="m_profile">
            <div id="m_profile_left">
                <!--USER IMAGE UPLOAD START HEAR-->
                <?php
                $image = "../_uploads/user_photo/" . $_SESSION['talent_id'] . ".jpg";
                //  if(file_exists($image)) 
                if (file_exists($image) && !isset($_GET['op'])) {
                    ?>
                    <img src="<?php echo $image . "?" . time() ?>"/>
                    <p>
                    <ul>
                        <li><a href="update_profile_photo.php<?php echo $user_idd; ?>">Manage Profile Photo</a></li>
                    </ul>
                    </p>
                <?php } else { ?>
                    <img src="../_images/dummy.png" />	
                    <!-- <p><a href="photo_upload.php">Add Profile Photo</a></p>	-->
                    <p>
                    <ul>
                        <li><a href="update_profile_photo.php<?php echo $user_idd; ?>">Add Profile Photo</a></li>
                    </ul>
                    </p>
                <?php } ?>
                <!--USER IMAGE UPLOAD END HEAR-->
                <ul>
                    <li><a href="change_password.php<?php echo $user_idd; ?>">Change Password</a></li>
                    <li><a href="edit_profile.php<?php echo $user_idd; ?>">Edit Profile</a></li>
                    <li><a href="profile_setup.php<?php echo $user_idd; ?>">Profile Setup</a></li>
                    <li><a href="update_payment_details.php<?php echo $user_idd; ?>">Payment Setup</a></li>
                    <li><a href="order_manage.php<?php echo $user_idd; ?>">Order Manage</a></li>
                    <li><a href="order-history.php<?php echo $user_idd; ?>">Order History</a></li>
                    <?php
                    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0)) {
                        $uid = $_SESSION["talent_id"];
                    }

                    $query = "SELECT * FROM tbl_msg WHERE to_id='" . $uid . "' AND view_status='0'";
                    $query_row = mysqli_query($link,$query);
                    $rows = mysqli_num_rows($query_row);
                    ?>
                    <li><a href="message.php<?php echo $user_idd; ?>">Message&nbsp;<?php echo "(" . $rows . ")"; ?></a></li>	
                    <li><a href="../profile-details.php?username=<?php echo $data['username']; ?>">View Public Profile</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </div>
            <div id="m_profile_right">
                <p>
                    <label>Name:</label> <?php echo $data['first_name'] . " " . $data['last_name']; ?>
                </p>
                <p>
                    <label>Email:</label> <?php echo $data['email']; ?>
                </p>
                <p>
                    <label>City:</label> <?php echo $data['city']; ?>
                </p>
                <p>
                    <label>Country:</label> <?php if(isset($countries_array[$data['country']])){echo $countries_array[$data['country']];} ?>
                </p>
                <p>
                    <label>Phone No:</label> <?php echo $data['phone_no']; ?>
                </p>
                <p>
                    <label>Sex:</label> <?php
                    if ($data['sex'] == 1) {
                        echo "Male";
                    } else {
                        echo "Female";
                    }
                    ?>
                </p>
                <!--<p>
                <label>Age:</label>
                <?php //echo $data['age']." "."years";   ?>
                </p>-->
                <p>
                    <label>Talents:</label>
                    <?php
                    $talent_list = $data['talent'];
                    $talent_list_tot = explode(',', $talent_list);
                    for ($i = 0; $i < count($talent_list_tot) - 1; $i++) {
                        echo talent($talent_list_tot[$i]) . ',' . ' ';
                    }
                    echo talent($talent_list_tot[count($talent_list_tot) - 1]) . ' .';
                    ?>
                </p>
                <div style="clear:both; float:left; width:100%;">
                    <div style="clear:both; float:left; text-align:left; width:50%;">
                        <iframe width="370" height="278" src="//www.youtube.com/embed/n5AFIangQ0w" frameborder="0" allowfullscreen></iframe>
                    </div>
                    <div style="float:right; text-align:left; width:50%;">
                        <iframe width="370" height="278" src="//www.youtube.com/embed/Q6hh5xAqAEM" frameborder="0" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php
include('../_includes/footer.php');
?>
