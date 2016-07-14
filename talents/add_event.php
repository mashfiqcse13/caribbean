<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit']) AND ( $_POST['submit']) == 'Add Event')) {

    /* USER IMAGE UPLOAD CHECK */
    $filename = $_FILES['img_path']['name'];
    $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

    //$file_ext= strrchr($filename, '.');
    $whitelist = array(".jpg", ".jpeg", ".gif", ".png");

    if (!in_array($file_ext, $whitelist)) {
        $MSG = 'Not allowed extension,please upload jpg,jpeg,gif,png images only!';
    } else {
        $event_date = explode('-', $_POST['event_date']);
        $event_date = $event_date['0'] . '-' . $event_date['1'] . '-' . $event_date['2'];
        $data = array(
            "uid" => $_SESSION["talent_id"],
            "name" => mysql_real_escape_string(trim($_POST['name'])),
            "event_date" => $event_date,
            "event_time" => mysql_real_escape_string(trim($_POST['event_time'])),
            "event_details" => mysql_real_escape_string(trim($_POST['event_details'])),
            "buy_url" => mysql_real_escape_string(trim($_POST['buy_url'])),
            "location" => mysql_real_escape_string(trim($_POST['location']))
        );
        $table = "tbl_profile_events";
        insertData($data, $table);

        $img_id = mysql_insert_id();

        $upload_file = $_FILES['img_path']['tmp_name'];
        $destination = "../_temp/" . $img_id . ".jpg";
        upload_my_file($upload_file, $destination);

        $source = "../_temp/" . $img_id . '.jpg';
        $dest = "../_uploads/profile_view_event_photo/thumb/" . $img_id . ".jpg";
        CreateFixedSizedImage($source, $dest, $width = 100, $height = 100);

        $destination = "../_uploads/profile_view_event_photo/" . $img_id . ".jpg";
        $size = PROFILE_PHOTO_BIG;
        create_thumb($source, $size, $destination);

        unlink("../_temp/" . $img_id . '.jpg');

        /* Added Activity Below */

        $uname = (GetChatUserName($_SESSION["talent_id"]));
        SaveActivity(6, $uname, mysql_real_escape_string(trim($_POST['name'])), $_SESSION["talent_id"]);

        //////////////////////////////////////////////////

        header("Location:manage_event.php?op=a");
    }
}
include('../_includes/header.php');
?> 

<script type="text/javascript">
    $(function () {
        $("#event_date").datepicker({
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            minDate: "+0D"

        });
    });

</script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#add_event').validate({
            rules: {
                img_path: {
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });
    });
</script>

<div class="content"><!--START CLASS content-->
    <h1>Add Event</h1>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='err'>" . $MSG . "</p>";
    }
    ?>
    <p style="text-align:right"><a href="manage_event.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a>

    <div class="form_class"><!--START CLASS form_class PART -->

        <div id="m_profile"><!--START CLASS m_profile PART -->

            <div id="m_profile_right"><!--START CLASS m_profile_right PART -->

                <!----------------------------------SESSION USER ADD EVENTS START--------------------------------->
                <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="add_event" enctype="multipart/form-data">

                    <p><label for="name">Name:</label>
                        <input type="text" name="name"  value="" class="required" />
                    </p>

                    <p><label for="event_date">Event Date:</label>
                        <input type="text" name="event_date" id="event_date" value="" class="required" />
                    </p>

                    <p><label for="event_time">Event Time:</label>
                        <input type="text" name="event_time"  value="" />
                    </p>

                    <p><label style="vertical-align:top;" for="event_details">Event Details:</label>
                        <textarea name="event_details" style="height:100px; width:300px;" class="required"></textarea>
                    </p>

                    <p><label for="location">Location:</label>
                        <input type="text" name="location"  value="" class="required"/>
                    </p>
                    <?php /* ?><p>
                      <label for="buy_url">Buy Url:</label>
                      <input type="text" name="buy_url" value="" />
                      </p><?php */ ?>
                    <p><label>Select Photo:</label><input type="file" name="img_path" value="" class="required"/></p>
                    <input type="submit" name="submit" value="Add Event" class="button"/>

                </form>
                <!----------------------------------SESSION USER ADD EVENTS END	--------------------------------->		

            </div><!--END CLASS m_profile_right PART -->

        </div><!--END CLASS m_profile PART -->

    </div><!--END CLASS form_class PART -->

</div><!--END CLASS content-->
<!--<script type="text/javascript" language="javascript">
$( "#add_event" ).validate({
        rules: {
                buy_url: {
                        url: true
                }
        }
});
</script>-->
<?php
include('../_includes/footer.php');
?>
