<?php
/*
 * This is the right side bar of a member account
 */
?>
<div id="m_profile_left">
    <!--START ID m_profile_left PART -->
    <!--USER IMAGE UPLOAD START HEAR-->

    <?php
    $image = "../_uploads/user_photo/" . $_SESSION['user_id'] . ".jpg";
    if (file_exists($image)) {
        ?>
        <img src="<?php echo $image . "?" . time() ?>"/>	
        <p>
        <ul>
            <li>
                <a href="update_profile_photo.php<?php echo $user_idd; ?>">Manage Profile Photo</a>
            </li>
        </ul>
    </p>
<?php } else { ?>
    <img src="../_images/dummy.png" />
    <p>
    <ul>
        <li>						
            <a href="update_profile_photo.php<?php echo $user_idd; ?>">Add Profile  Photo</a>
        </li>
    </ul>
    </p>		
<?php } ?>					
<!--USER IMAGE UPLOAD END HEAR-->
<!--MENU START-->
<?php
$result = mysqli_query($link, "SELECT * FROM tbl_users WHERE id='" . $_SESSION['user_id'] . "'");
if (!$result) {
    die("database query faild:" . mysqli_error($link));
}
$user_row = mysqli_fetch_assoc($result);
?>
<ul>

    <li><a href="change-password.php<?php echo $user_idd; ?>">Change Password</a></li>
    <li><a href="edit-profile.php<?php echo $user_idd; ?>">Edit Profile</a></li>
    <li><a href="profile_setup.php<?php echo $user_idd; ?>">Profile Setup</a></li>
    <li><a href="my_fav_items.php<?php echo $user_idd; ?>">My Favorites</a></li>
    <li><a href="order-history.php<?php echo $user_idd; ?>">Order History</a></li>

    <?php
    if ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0)) {
        $uid = $_SESSION["user_id"];
    }

    $query = "SELECT * FROM tbl_msg WHERE to_id='" . $uid . "' AND view_status='0'";
    $query_row = mysqli_query($link, $query);
    $rows = mysqli_num_rows($query_row);
    ?>

    <li><a href="message.php<?php echo $user_idd; ?>">Message&nbsp;<?php echo "(" . $rows . ")"; ?></a></li>
    <li><a href="../profile-details.php?username=<?php echo $user_row['username']; ?>">View Public Profile</a></li>
    <li><a href="log-out.php">Logout</a></li>
</ul>
<!--MENU END-->
</div>