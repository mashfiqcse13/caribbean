<style>
    .music_div h4 {
        padding: 0 0 5px;
    }
</style>
<?php

function show_music($music_id) {
    $src = "_uploads/profile_music/" . $music_id . ".mp3";
    $output = '<audio controls>
        <source src="' . $src . '" type="audio/ogg">
      Your browser does not support the audio element.
      </audio>';
    return $output;
}

$query3 = mysqli_query($link,"SELECT tbl_users.*, tbl_profile_music.*,tbl_profile_music.id AS music_id FROM tbl_users LEFT OUTER JOIN 
							tbl_profile_music ON tbl_users.id=tbl_profile_music.user_id WHERE username ='" . $_GET['username'] . "' AND tbl_profile_music.status='1'  
							ORDER BY tbl_profile_music.id DESC LIMIT 0, 4 ");
//$de=mysqli_fetch_assoc($query3);
// print_r($de);
$numrows = mysqli_num_rows($query3);
if ($numrows > 0) {
    ?>


    <div class="music_div"><!--START DIV CLASS music_div-->

        <!--	<a href="#">
                <div class="ply_btn">
                <span>I Remember Me</span></a></div>-->

        <h2>Music</h2>
        <ul>
            <?php
            while ($row3 = mysqli_fetch_assoc($query3)) {
                $sql = mysqli_query($link,"SELECT * FROM  tbl_products WHERE ref_id='" . $row3['music_id'] . "' ");
                $res = mysqli_fetch_assoc($sql);
                $row1 = mysqli_num_rows($sql);

                if ($res['id'] != '') {
                    $pid = $res['id'];
                } else {
                    $pid = 0;
                }
                ?>	
                <li>

                <!--                    <a  style="float:right;color:#FFFFFF; cursor:pointer;"  onclick="return popitup('music.php?Mid=<?php echo $row3['music_id']; ?>&Pid=<?php echo $pid; ?>')" title="Play Music">
                                        <div style="margin-top:-9px;" class="ply_btn"></div>
                                    </a>-->
                    <h4><?php echo $row3["music_title"]; ?></h4>
                    <?php echo show_music($row3['music_id']) ?>
                </li>
                <?php
            }
            ?>
            <a class="profile_btn" href="profile-music.php?id=<?php echo $data['id']; ?>">All Songs</a>
        </ul>

    </div><!--END DIV CLASS music_div-->
<?php } ?>	 