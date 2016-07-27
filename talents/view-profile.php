<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<div id="contant">
    <!--	<ul>
                    <li><a href="profile_setup.php">Back</a></li>
            </ul>-->
    <?php
    /* $query=mysqli_query($link,"SELECT * FROM  tbl_profile_photos "); */
    $query = mysqli_query($link,"SELECT tbl_profile_photos.*,tbl_users.username FROM tbl_profile_photos LEFT JOIN tbl_users ON tbl_profile_photos.user_id=tbl_users.id ");
    ?>

    <?php
    while ($row = mysqli_fetch_assoc($query)) {
        ?>
        <!--/////ALL USER UPLOAD IMAGE/////-->
        <div id="a_image">		
            <ul>
                <li>
                        <!--<img src="../_uploads/profile_photo/thumb/<?php echo $row["id"]; ?>.jpg" />-->
                    <a href="../_uploads/profile_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="../_uploads/profile_photo/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/></a><br />
                    <a href="profile-details.php?username=<?php echo $row["username"]; ?>" target="_blank"><?php echo $row["photo_title"]; ?></a>										

                </li>
            </ul>
        </div>
        <?php
    }
    ?>
</div>

<?php
include('../_includes/footer.php');
?>
