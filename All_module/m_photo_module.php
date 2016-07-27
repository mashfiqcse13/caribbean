<h2 style="margin-bottom:10px;">photos</h2>
<?php
$qry = getAnyTableWhereData("tbl_users", "AND username='" . $_GET['username'] . "' ");

$weq = $qry['type'];

$query = mysqli_query($link,"SELECT p.id AS PID, u.id AS UID,u.type FROM tbl_profile_photos AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.user_id WHERE u.username='" . $_GET['username'] . "' ORDER BY p.id DESC LIMIT 3");

if ((mysqli_num_rows($query) > 0) && ($weq == 0)) {
    ?>
    <?php
    while ($row1 = mysqli_fetch_assoc($query)) {
        ?>

        <div class="profile_details_bottom">
            <a href="profile-images.php?id=<?php echo $row1['UID']; ?>" title="View All Photos">
                <img src="_uploads/profile_photo/thumb/<?php echo $row1['PID']; ?>.jpg" alt=" " width="100"/>
            </a>
        </div>

        <?php
    }
    ?>

    <a class="profile_btn" href="profile-images.php?id=<?php echo $profile_id; ?>">All photos</a>
    <?php
}
?>