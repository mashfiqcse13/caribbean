<?php
/* * All fans Here* */

$result5 = "SELECT * FROM  tbl_fans WHERE fan_id='" . $data['id'] . "' ORDER BY tbl_fans.id DESC";
$sql5 = mysql_query($result5);
$number = mysql_num_rows($sql5);
//echo $number;
//$data5=mysql_fetch_assoc($sql5);
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
            while ($data5 = mysql_fetch_assoc($sql5)) {
                $result6 = mysql_query("SELECT username FROM  tbl_users WHERE id=" . $data5["profile_id"] . "");
                $sql6 = mysql_fetch_assoc($result6);
                //print_r($sql6);
                ?>
                <li><a href="profile-details.php?username=<?php echo $sql6['username'] ?>"><img src="_uploads/user_photo/<?php echo $data5["profile_id"] ?>.jpg" style="width:60px; height:45px;"/></a></li>
                <?php
            }
            ?>
            <div class="fansbtn_top_spece"><a class="profile_btn" href="profile-fans.php?id=<?php echo $data['id']; ?>">All Fans</a></div>
        </ul>
    </div>
<?php } ?>