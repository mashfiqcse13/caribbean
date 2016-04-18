<?php
$cur_date = date('Y-m-d');
$query_event = mysql_query("SELECT p.*, u.id AS UID FROM tbl_profile_events AS p LEFT OUTER JOIN tbl_users AS u ON u.id=p.uid WHERE u.username='" . $_GET['username'] . "' AND p.event_date >= '" . $cur_date . "' ORDER BY p.id DESC LIMIT 3");
?>
<?php
if (mysql_num_rows($query_event) > 0) {
    ?>
    <div class="eventandshows_div"><!--START DIV CLASS eventandshows_div-->
        <h2 class="txt_1">events and shows</h2>

        <?php
        while ($rows_event = mysql_fetch_assoc($query_event)) {
            ?>

            <div class="event_detail"><a href="all_events_shows.php?id=<?php echo $rows_event['UID']; ?>" title="All Events & Shows"><!--START DIV CLASS event_detail-->
                    <div class="event_detail_left">
                        <div class="show_date">																
                            <p><?php echo date('Y', strtotime($rows_event['event_date'])); ?></p>
                            <p><?php echo date('F j', strtotime($rows_event['event_date'])); ?></p>																
                        </div>
                    </div>
                    <div class="event_detail_right">
                        <h3><?php echo $rows_event['name']; ?></h3>
                        <span><?php echo $rows_event['location']; ?> | <?php echo $rows_event['event_time']; ?></span> 
                    </div>
                    <div class="clear"></div>
                </a> </div><!--END DIV CLASS event_detail-->

            <?php
        }
        ?>
    </div><!--END DIV CLASS eventandshows_div-->
    <div class="eventbtn_top_spece">
        <a class="profile_btn" href="all_events_shows.php?id=<?php echo $profile_id; ?>">All Events & Shows</a> 
    </div>

    <?php
}
?>