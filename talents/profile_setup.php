<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');

$data = getAnyTableWhereData("tbl_users", "AND id=" . $_SESSION['talent_id'] . " ");

$uname = $data['username'];
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_loin').validate();
    });
</script>
<div class="content"><!--START CLASS content-->
    <h1>Set Your Profile</h1>
    <p><a href="member.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p>


    <div class="form_class"><!--START CLASS form_class-->
        <div id="m_profile"><!--START ID m_profile PART -->
            <div id="m_profile_left"><!--START ID m_profile_left PART -->
                <ul>
                    <!--<li><a href="member.php">Back</a></li>-->
                    <li><a href="add_profile_settings.php<?php echo $user_idd; ?>">Profile Settings</a></li>
                    <li><a href="add_profile_details.php<?php echo $user_idd; ?>">Profile Details</a></li>
                    <!--<li><a href="profile-photo.php">Profile Photo</a></li>-->
                    <li><a href="manage_photo.php<?php echo $user_idd; ?>">Manage Photo</a></li>
                    <li><a href="manage_music.php<?php echo $user_idd; ?>">Manage Music</a></li> 
                    <li><a href="manage_video.php">Manage Video</a></li>
                    <li><a href="manage_event.php<?php echo $user_idd; ?>">Manage Event</a></li>
                    <li><a href="manage_book.php<?php echo $user_idd; ?>">Manage Book</a></li>
                    <li><a href="manage_product.php">Manage Product</a></li>

                    <hr />
                    <li style="margin-top:20px;"><a href="../profile-details.php?username=<?php echo $uname; ?>" >View Public Profile</a></li>
                </ul>
            </div><!--END ID m_profile_left PART -->
        </div><!--END ID m_profile PART -->
    </div><!--END CLASS form_class-->
</div><!--END CLASS content-->
<?php
include('../_includes/footer.php');
?>