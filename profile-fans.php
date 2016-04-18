<?php
include('_includes/application-top.php');
$data = getAnyTableWhereData("tbl_users", "AND id='" . $_GET['id'] . "' ");
include('_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<div class="content"><!--START CLASS contant PART -->
    <?php
    if ($data['type'] == 1) {
        ?>
        <h2>All Fans</h2>
        <?php
    } else {
        ?>
        <h2>All Friends</h2>
        <?php
    }
    ?>
    <p style="text-align:right"><a href="javascript:fans(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a><br />
        <?php
        $query = mysql_query("SELECT * FROM tbl_fans WHERE profile_id='" . $_GET['id'] . "' ORDER BY tbl_fans.id DESC");
        ?>
    <ul>
        <?php
        while ($rows = mysql_fetch_assoc($query)) {
            $query2 = mysql_query("SELECT username FROM tbl_users WHERE id='" . $rows['fan_id'] . "'");
            $row = mysql_fetch_assoc($query2);
            //print_r($row);
            ?>
            <li class="b_image">

                <a href="profile-details.php?username=<?php echo $row['username']; ?>"><img src="_uploads/user_photo/<?php echo $rows["fan_id"]; ?>.jpg" height="100" width="80"/></a>
                <p style="text-align:center;"><a href="profile-details.php?username=<?php echo $row['username']; ?>"><?php echo $row['username']; ?></a></p>
            </li>
            <?php
        }
        ?>
    </ul>
    <div style="clear:both;"></div>
</div>


<?php
include('_includes/footer.php');
?>
