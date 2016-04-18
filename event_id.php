<?php
include('_includes/application-top.php');
include('_includes/header.php');
?>
<script type="text/javascript">
    function back()
    {
        window.history.back();
    }
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h2>EVENTS AND SHOWS</h2>
    <p style="text-align:right"><a href="javascript:back(0)" class="button" style="float:left; margin:-5px 0px 0px 0px;" onclick="return back();">Back</a><br />
        <?php
        //$query=mysql_query("SELECT * FROM tbl_profile_events WHERE uid='".$_GET['id']."' ORDER BY tbl_profile_events.id DESC");

        $cur_date = date('Y-m-d');
        $query = mysql_query("SELECT * FROM tbl_profile_events WHERE id='" . $_GET['id'] . "' AND event_date >= '" . $cur_date . "' ORDER BY event_date ")
        ?>
    <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->			

        <div class="eventandshows_div_all_events"><!--START DIV CLASS eventandshows_div_all_events-->	


            <?php
            while ($row = mysql_fetch_assoc($query)) {
                ?>

                <div class="event_detail_all_events"><!--START DIV CLASS event_detail_all_events-->
                    <div class="event_detail_left_all_events">

                        <div class="show_date">																
                            <p><?php echo date('Y', strtotime($row['event_date'])); ?></p>
                            <p><?php echo date('F j', strtotime($row['event_date'])); ?></p>																
                        </div>
                    </div>
                    <div class="event_detail_right_all_events">

                        <a href="#"><img src="_uploads/profile_view_event_photo/thumb/<?php echo $row["id"]; ?>.jpg" alt="my_img"/></a>
                        <h3><?php echo $row['name']; ?></h3><br />
                        <span><?php echo $row['location']; ?> | <?php echo $row['event_time']; ?></span> 
                        <?php
                        if ($row['buy_url'] != '') {
                            ?>
                            <a href="<?php echo $row['buy_url']; ?>"><img style="margin-left:-5px;" src="_images/buy-tickets.png" title="Buy Tickets" width="70px;" /></a>
                            <?php
                        }
                        ?>
                    </div>

                    <div class="clear"></div>
                    <hr />
                    <img src="_uploads/profile_view_event_photo/<?php echo $row["id"]; ?>.jpg" alt="my_img"/><br /><br /><br />
                    <div class="event_details"><p><?php echo nl2br($row['event_details']); ?></p></div>
                    <?php
                }
                ?>
            </div><!--END DIV CLASS event_detail_all_events-->					
        </div><!--END DIV CLASS eventandshows_div_all_events-->

    </div>
    <div style="clear:both"></div>
</div><!--END CLASS contant PART -->

<?php
include('_includes/footer.php');
?>
