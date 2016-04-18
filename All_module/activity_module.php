<?php
$query_activity = mysql_query("SELECT ac.id AS ACID,ac.user_id,ac.activity,ac.activity_time, u.id AS UID,u.first_name,u.last_name FROM  tbl_user_activity AS ac LEFT OUTER JOIN tbl_users AS u ON u.id=ac.user_id WHERE u.username='" . $_GET['username'] . "' ORDER BY ac.id DESC LIMIT 6");
?>

<div class="div_activity"><!--START DIV comment_div-->
    <h2 style="margin-bottom:10px;">activity</h2>	
    <?php
    if (mysql_num_rows($query_activity) > 0) {
        ?>
        <ul>	
            <?php
            while ($row_activity = mysql_fetch_assoc($query_activity)) {
                //$query_username=mysql_query("SELECT username FROM tbl_users WHERE id='".$row_comment['commenter_id']."' ");
                //$rows_username=mysql_fetch_assoc($query_username);
                ?>
                <li>
                    <h3><?php echo $row_activity['activity']; ?></h3>
                    <p><?php echo $row_activity['activity_time']; ?></p>
                </li>
                <?php
            }
            ?>
        </ul>			
        <?php
    }
    ?>
    <div class="comntbtn_top_spece"><a class="profile_btn" href="profile_all_activity.php?id=<?php echo $data['id']; ?>">All Activity</a></div>
</div><!--END DIV comment_div-->