<?php

$query4 = mysqli_query($link,"SELECT tbl_users.*,  tbl_profile_videos.*,tbl_profile_videos.id AS video_id FROM tbl_users LEFT OUTER JOIN 
					 tbl_profile_videos ON tbl_users.id= tbl_profile_videos.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_videos.status='1'  ORDER BY tbl_profile_videos.id DESC LIMIT 1");
$number = mysqli_num_rows($query4);
if ($number > 0) {
    ?>
    <div class="video_div">
        <h2>Video</h2>
        <?php
        while ($row4 = mysqli_fetch_assoc($query4)) {
            echo show_video($row4["video_type"], $row4["video_id"]);
        }
        ?>

        <a class="profile_btn" href="profile-video.php?id=<?php echo $data['id']; ?>">All Videos</a>
    </div>
    <?php
}?>