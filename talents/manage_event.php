<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<div class="content"><!--START CLASS content-->
    <h1>Profile Events</h1>
    <p style="text-align:right"><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><a href="add_event.php" class="button">Add Event</a></p>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
        echo "<p class='msg'>Record Added  Successfully</p>";
    }
    ?>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
        echo "<p class='msg'>Record Updated Sucessfully</p>";
    }
    ?>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
        echo "<p class='err'>Record Deleted Sucessfully</p>";
    }
    ?>
    <!-------------------------------------START QUERY FROM DATABASE USER EVENTS---------------------------------------->		
    <?php
    $query = mysql_query("SELECT * FROM   tbl_profile_events WHERE uid='" . $_SESSION['talent_id'] . "' order by  tbl_profile_events.id desc ");
    $number = mysql_num_rows($query);
    ?>

    <?php
    if ($number <= 0) {
        echo "<p class='err'>No Record Found!</p>";
    } else {
        ?>
        <table cellpadding="0" cellspacing="0" class="TabUIRecords">
            <thead>
                <tr>
                    <th align="center">Photo</th>
                    <th style="text-align:left;">Name</th>
                    <th style="text-align:left;">Event Date </th>
                    <th style="text-align:left;">Event Time</th>
                    <th style="text-align:left;">Location</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysql_fetch_assoc($query)) {
                ?>	
                <tr>
                    <td width="8%"><a href="../_uploads/profile_view_event_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox"><img src="../_uploads/profile_view_event_photo/thumb/<?php echo $row["id"]; ?>.jpg" style="margin:10px 10px 10px 10px;" alt=""/></a></td>
                    <td align="left"><?php echo $row['name']; ?></td>
                    <td align="left"><?php echo $row['event_date']; ?></td>
                    <td align="left"><?php echo $row['event_time']; ?></td>
                    <td align="left"><?php echo $row['location']; ?></td>
                    <td align="center"><a href="update_event.php?id=<?php echo $row["id"]; ?>"><img src="../_images/Edit.png" title="Update Event"></a>&nbsp;&nbsp;<a href="<?php echo "javascript:ConfrimMessage_Delete('delete_event.php?id=$row[id]')"; ?>"><img src="../_images/del.png" title="Delete Event"></a></td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
    <!-------------------------------------END QUERY FROM DATABASE USER EVENTS---------------------------------------->			

</div><!--END CLASS content-->

<?php
include('../_includes/footer.php');
?>
