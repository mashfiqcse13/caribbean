<?php
/* * All fans Here* */

$result5 = "SELECT * FROM  tbl_fans WHERE fan_id='" . $data['id'] . "' ORDER BY tbl_fans.id DESC";
$sql5 = mysqli_query($link,$result5);
$number = mysqli_num_rows($sql5);
//echo $number;
//$data5=mysqli_fetch_assoc($sql5);
//print_r($data5);
?>
<div class="fan_button"><a href="add_fans.php?username=<?php echo $_GET['username']; ?>"><img src="_images/fan_btn.png" border="0"/></a></div>
<?php
if ($number <> 0) {
    ?>     
    <div class="fans_div">

        <h2>Fans</h2>
        <ul>
            <?php
            while ($data5 = mysqli_fetch_assoc($sql5)) {
                $result6 = mysqli_query($link,"SELECT username FROM  tbl_users WHERE id=" . $data5["profile_id"] . "");
                $sql6 = mysqli_fetch_assoc($result6);
                $fans_profile_pic_url = "_uploads/user_photo/{$data5["profile_id"]}.jpg";
                if (file_exists("../$friends_profile_pic_url")) {
                    $fans_profile_pic_url.="?" . time();
                } else {
                    $fans_profile_pic_url = "_images/dummy.png";
                }
                ?>
                <li><a href="profile-details.php?username=<?php echo $sql6['username'] ?>"><img src="<?php echo $fans_profile_pic_url ?>" style="width:90px; height:120px;"/></a></li>
                <?php
            }
            ?>
            <div class="fansbtn_top_spece"><a class="profile_btn" href="profile-fans.php?id=<?php echo $data['id']; ?>">All Fans</a></div>
        </ul>
    </div>
<?php } ?>