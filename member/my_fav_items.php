<?php
/*
 * members will see their favorite items here .
 */

include('../_includes/application-top.php');
ChecknontalentLogin();
$user_id = $_SESSION['user_id'];
include('../_includes/header.php');
?>
<div class="content"><!--START CLASS contant PART -->
    <h1>Member Area</h1>		
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile">
            <!--START ID m_profile PART -->
            <?php include('./profile_template/sidebar_right.php'); ?>
            <!--END CLASS m_profile_left PART -->
            <div id="m_profile_right_1"><!--START ID m_profile_right PART -->
                <?php include '../All_module/user-fav/images-modul.php'; ?>
                <?php include '../All_module/user-fav/music-modul.php'; ?>
                <?php include '../All_module/user-fav/video-modul.php'; ?>
            </div>
        </div>
    </div>
</div>

<?php include('../_includes/footer.php'); ?>