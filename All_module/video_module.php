<?php
$query4 = mysql_query("SELECT tbl_users.*,  tbl_profile_videos.*,tbl_profile_videos.id AS video_id FROM tbl_users LEFT OUTER JOIN 
					 tbl_profile_videos ON tbl_users.id= tbl_profile_videos.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_videos.status='1'  ORDER BY tbl_profile_videos.id DESC LIMIT 1");
$number = mysql_num_rows($query4);
if ($number > 0) {
    ?>
    <div class="video_div">
        <h2>Video</h2>
        <?php
        while ($row4 = mysql_fetch_assoc($query4)) {
            ?>
            <a title="Play Video"  id="video" <?php if ($row4["video_type"] == 1) { ?>href="talents/video_play.php?filename=_uploads/profile_video/<?php echo $row4["video_id"]; ?>.mp4" <?php } else {
                ?> href="talents/video_play.php?id=<?php echo $row4["video_id"];
        }
            ?>" >

                <div class="video_ply_btn"><img src="_images/vido_play_btn.png" border="0"/></div>

            </a>
            <img src="_uploads/video_photo/<?php echo $row4["video_id"]; ?>.jpg" width="315" height="220"/>

            <?php
        }
        ?>

        <a class="profile_btn" href="profile-video.php?id=<?php echo $data['id']; ?>">All Videos</a>
    </div>
    <?php
}?>