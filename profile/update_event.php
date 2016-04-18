<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    $event_date = explode('/', $_POST['event_date']);
    $event_date = $event_date['0'] . '-' . $event_date['1'] . '-' . $event_date['2'];
    $data = array(
        "uid" => $_SESSION["talent_id"],
        "name" => mysql_real_escape_string(trim($_POST['name'])),
        "event_date" => $event_date,
        "event_time" => mysql_real_escape_string(trim($_POST['event_time'])),
        "location" => mysql_real_escape_string(trim($_POST['location']))
    );
    $table = "tbl_profile_events";
    $parameters = "id='" . $_GET['id'] . "'";
    updateData($data, $table, $parameters);
    header("Location:manage_event.php?op=u");
}
?>
<?php include('../_includes/header.php'); ?>
<script type="text/javascript">
    $(function () {
        $("#event_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy/mm/dd'
        });
    });
</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#update_event').validate()
    });
</script>

<div class="content"><!--START CLASS contant PART -->
    <h1>Upadte Event</h1>
    <p style="text-align:right"><a href="manage_event.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>
    <div class="form_class"><!--START CLASS form_class PART -->
        <div id="m_profile"><!--START CLASS m_profile PART -->
            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->
                <?php
                $query = mysql_query("SELECT * FROM  tbl_profile_events WHERE id='" . $_GET['id'] . "'")
                ?>

                <?php
                while ($row = mysql_fetch_assoc($query)) {
                    ?>
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="update_event">
                        <p>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo $row["name"] ?>" class="required" />
                        </p>
                        <p>
                            <label for="event_date">Event Date:</label>
                            <input type="text" name="event_date" value="<?php $event_date = explode('-', $row['event_date']);
                echo $event_date = $event_date['0'] . '/' . $event_date['1'] . '/' . $event_date['2'];
                    ?>" id="event_date" class="required" />
                        </p>
                        <p>
                            <label for="event_time">Event Time:</label>
                            <input type="text" name="event_time" value="<?php echo $row["event_time"] ?>"  />
                        </p>
                        <p>
                            <label for="location">Location:</label>
                            <input type="text" name="location" value="<?php echo $row["location"] ?>" class="required" />
                        </p>
                        <input type="submit" name="submit" value="Update" class="button" />
                    </form>
                    <?php
                }
                ?>					
            </div><!--END CLASS m_profile_right PART -->
        </div><!--END CLASS m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<?php include('../_includes/footer.php'); ?>



