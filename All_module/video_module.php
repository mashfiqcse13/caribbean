<?php

function show_video($video_type, $video_id) {

    if ($video_type == 1) {     // means it is a file type
        $src = '_uploads/profile_video/' . $video_id . '.mp4';
        echo $src;
        $output = '<video  width="315" height="220" controls>
                    <source src="' . $src . '" type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                  Your browser does not support the video tag.
                  </video>';
    } else if (!empty($video_id)) {        // there is a video code
        global $connt, $selt;
        $result = mysql_query("SELECT * FROM  tbl_profile_videos WHERE id='" . $video_id . "' ");
        $data = mysql_fetch_assoc($result);
        //print_r($data);
        $output = preg_replace('/width=("|\')(\d+|\d+px|)("|\')/i', 'width="315"', $data['video_code']);
        $output = preg_replace('/height=("|\')(\d+|\d+px|)("|\')/i', 'height="220"', $output);
    }
    return $output;
}

$query4 = mysql_query("SELECT tbl_users.*,  tbl_profile_videos.*,tbl_profile_videos.id AS video_id FROM tbl_users LEFT OUTER JOIN 
					 tbl_profile_videos ON tbl_users.id= tbl_profile_videos.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_videos.status='1'  ORDER BY tbl_profile_videos.id DESC LIMIT 1");
$number = mysql_num_rows($query4);
if ($number > 0) {
    ?>
    <div class="video_div">
        <h2>Video</h2>
        <?php
        while ($row4 = mysql_fetch_assoc($query4)) {
            echo show_video($row4["video_type"], $row4["video_id"]);
        }
        ?>

        <a class="profile_btn" href="profile-video.php?id=<?php echo $data['id']; ?>">All Videos</a>
    </div>
    <?php
}?>