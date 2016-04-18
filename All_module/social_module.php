<?php
$query112 = mysql_query("SELECT b.id AS BID,b.*, u.id AS UID,u.type FROM  tbl_user_details AS b LEFT OUTER JOIN tbl_users AS u ON u.id=b.user_id 
                                                WHERE u.username='" . $_GET['username'] . "'");
$weq111 = mysql_fetch_assoc($query112);
//print_r($weq111);

if (($weq111["social_link1"] != '') || ($weq111["social_link2"] != '') || ($weq111["social_link3"] != '') || ($weq111["social_link4"] != '')) {
    ?>
    <div class="social_links">
        <h2>Social Links</h2>
        <?php
        if ($weq111["social_link1"] != '') {
            ?>
            <a href="<?php echo $weq111["social_link1"]; ?>"><img src="_images/fcbk_socl_mdia.png" border="0" alt="facebook"/></a>
            <?php
        }
        if ($weq111["social_link2"] != '') {
            ?>
            <a href="<?php echo $weq111["social_link2"]; ?>"><img src="_images/twiter_socl_mdia.png" border="0" alt="twitter"/></a>
            <?php
        }
        if ($weq111["social_link3"] != '') {
            ?>
            <a href="<?php echo $weq111["social_link3"]; ?>"><img src="_images/gplus_socl_mdia.png"border="0" alt="googleplus"/></a>
            <?php
        }
        if ($weq111["social_link4"] != '') {
            ?>
            <a href="<?php echo $weq111["social_link4"]; ?>"><img src="_images/lindn_socl_mdia.png"border="0" alt="linkdin"/></a>
        <?php } ?>

    </div>
<?php }
?>     