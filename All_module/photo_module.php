<?php
//echo "SELECT p.id AS PID, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='".$_GET['username']."' ORDER BY p.id DESC LIMIT 3";

$qry = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");

$weq = $qry['type'];

$query = mysql_query("SELECT p.id AS PID,p.croped AS Pstatus, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='" . $_GET['username'] . "' ORDER BY p.id DESC LIMIT 3");

if ((mysql_num_rows($query) > 0) && ($weq == 1)) {
    ?>
    <?php
    while ($row1 = mysql_fetch_assoc($query)) {
        ?>

        <div class="profile_details_bottom">
            <a href="profile-images.php?id=<?php echo $row1['UID']; ?>" title="View All Photos">
                <?php
                $img_name = "{$row1["PID"]}.jpg?" . time();
                if ($row1["Pstatus"] == 33) {
                    ?>
                    <img src="../_uploads/profile_photo/croped/<?php echo $img_name; ?>" width="100" />
                <?php } else { ?>
                    <img src="../_uploads/profile_photo/thumb/<?php echo $img_name; ?>" width="100"/>
        <?php } ?>
            </a>
        </div>

        <?php
    }
    ?>

    <a class="profile_btn" href="profile-images.php?id=<?php echo $profile_id; ?>">All Photos</a>
    <?php
}
?>