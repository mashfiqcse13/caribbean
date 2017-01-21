<?php
$query2 = mysqli_query($link,"SELECT b.id AS BID,b.*, u.id AS UID,u.type FROM  tbl_user_details AS b LEFT OUTER JOIN tbl_users AS u ON u.id=b.user_id 
                            WHERE u.username='" . $_GET['username'] . "'");
$weq1 = mysqli_fetch_assoc($query2);
//print_r($weq1);										
$row2 = mysqli_fetch_assoc($query2);
//print_r($row2);
if ((mysqli_num_rows($query2) > 0) && ($weq1['type'] == 1) && ($weq1['profile_display_status'] == 1)) {
    ?>
    <div class="bio_div">

        <h2>Bio</h2>
        <p style="color:#000000; font-weight:bold;"><?php echo nl2br(substr($weq1["biography"], 0, 44)); ?></p>
        <a class="profile_btn" href="view_detailse.php?id=<?php echo $data['id']; ?>">View Details</a>

    </div>
    <?php
}
?>