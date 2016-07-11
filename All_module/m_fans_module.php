                  
<div class="fans_div">
    <!--become fan--> 

    <div class="fan_button"><a href="add_fans.php?username=<?php echo $_GET['username']; ?>"><img src="_images/friend_btn.png" border="0"/></a></div>

    <h2>Friends</h2>
    <ul>
        <?php
        $result55 = "SELECT * FROM  tbl_fans WHERE fan_id='" . $data['id'] . "' ORDER BY tbl_fans.id DESC";
        $sql55 = mysql_query($result55);
        $number5 = mysql_num_rows($sql55);
        while ($data55 = mysql_fetch_assoc($sql55)) {
            $result66 = mysql_query("SELECT username FROM  tbl_users WHERE id=" . $data55["profile_id"] . "");
            $sql66 = mysql_fetch_assoc($result66);

            $friends_profile_pic_url = "_uploads/user_photo/{$data55["profile_id"]}.jpg";
            if (file_exists("$friends_profile_pic_url")) {
                $friends_profile_pic_url.="?" . time();
            } else {
                $friends_profile_pic_url = "_images/dummy.png";
            }
            ?>
            <li><a href="profile-details.php?username=<?php echo $sql66['username'] ?>"><img src="<?php echo $friends_profile_pic_url ?>" style="width:60px; height:45px;"/></a></li>
            <?php
        }
        ?>
        <div class="fansbtn_top_spece"><a class="profile_btn" href="profile-fans.php?id=<?php echo $data['id']; ?>">All Friends</a></div>
    </ul>
</div>