<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    /* USER IMAGE UPLOAD */
    if ((isset($_FILES['img_path']['name'])) && ($_FILES['img_path']['name'] != '')) {
        $filename = $_FILES['img_path']['name'];
        $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

        //$file_ext = strrchr($filename, '.');
        $whitelist = array(".jpg", ".jpeg", ".gif", ".png");
        if (!in_array($file_ext, $whitelist)) {
            $MSG = 'Not allowed extension,please upload ".jpg",".jpeg",".gif",".png" only!';
        } else {
            $event_date = explode('-', $_POST['event_date']);
            $event_date = $event_date['0'] . '-' . $event_date['1'] . '-' . $event_date['2'];
            $data = array(
                "uid" => $_SESSION["talent_id"],
                "name" => mysql_real_escape_string(trim($_POST['name'])),
                "event_date" => $event_date,
                "event_time" => mysql_real_escape_string(trim($_POST['event_time'])),
                "event_details" => mysql_real_escape_string(trim($_POST['event_details'])),
                "location" => mysql_real_escape_string(trim($_POST['location']))
            );
            $table = "tbl_profile_events";
            $parameters = "id='" . $_GET['id'] . "'";
            updateData($data, $table, $parameters);
            $table = "tbl_profile_events";

            $parameters = "id='" . $_GET['id'] . "'";
            updateData($data, $table, $parameters);

            $upload_file = $_FILES['img_path']['tmp_name'];
            $destination = "../_temp/" . $_GET['id'] . ".jpg";
            upload_my_file($upload_file, $destination);

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $dest = "../_uploads/profile_view_event_photo/thumb/" . $_GET['id'] . ".jpg";
            CreateFixedSizedImage($source, $dest, $width = 100, $height = 100);

            $source = "../_temp/" . $_GET['id'] . '.jpg';
            $destination = "../_uploads/profile_view_event_photo/" . $_GET['id'] . ".jpg";
            $size = PROFILE_PHOTO_BIG;
            create_thumb($source, $size, $destination);

            unlink("../_temp/" . $_GET['id'] . '.jpg');

            header("Location:manage_event.php?op=u");
        }
    } else {
        $event_date = explode('/', $_POST['event_date']);
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
        $parameters = "id='" . $_GET['id'] . "'";
        updateData($data, $table, $parameters);
        header("Location:manage_event.php?op=u");
    }
}
?>
<?php include('../_includes/header.php'); ?>
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
        $('#update_event').validate({
            rules: {
                img_path: {
                    accept: "jpg,png,jpeg,gif"
                }
            },
        });

    });
</script>



<div class="content"><!--START CLASS contant PART -->
    <h1>Upadte Event</h1>
    <?php
    if (isset($MSG) AND ( $MSG <> "")) {
        echo "<p class='err'>" . $MSG . "</p>";
    }
    ?>
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
                    <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="update_event" enctype="multipart/form-data">
                        <p>
                            <label for="name">Name:</label>
                            <input type="text" name="name" value="<?php echo $row["name"] ?>" class="required" />
                        </p>
                        <p>
                            <label for="event_date">Event Date:</label>
                            <input type="text" name="event_date" value="<?php $event_date = explode('-', $row['event_date']);
                echo $event_date = $event_date['0'] . '-' . $event_date['1'] . '-' . $event_date['2'];
                    ?>" id="event_date" class="required" />
                        </p>
                        <p>
                            <label for="event_time">Event Time:</label>
                            <input type="text" name="event_time" value="<?php echo $row["event_time"] ?>"  />
                        </p>
                        <p><label style="vertical-align:top;" for="event_details">Event Details:</label>
                            <textarea name="event_details" style="height:100px; width:300px;" class="required"><?php echo $row["event_details"] ?></textarea>
                        </p>
                        <p>
                            <label for="location">Location:</label>
                            <input type="text" name="location" value="<?php echo $row["location"] ?>" class="required" />
                        </p>

                        <?php
                        $img_path = "../_uploads/profile_view_event_photo/thumb/" . $row['id'] . ".jpg";
                        if (file_exists($img_path)) {
                            ?>

                            <p style="margin-left:140px;">
                                <a href="../_uploads/profile_view_event_photo/<?php echo $row["id"]; ?>.jpg" class="fancybox">
                                    <img src="<?php echo $img_path; ?>" alt="Image"/>
                                </a>
                            </p>
                            <?php
                        }
                        ?>
                        <?php /* ?><p>
                          <label for="buy_url">Buy Url:</label>
                          <input type="text" name="buy_url" value="<?php echo $row["buy_url"]; ?>" />
                          </p><?php */ ?>
                        <p><label>Select Photo:</label><input type="file" name="img_path" value="" /></p>

                        <input type="submit" name="submit" value="Update" class="button" />
                    </form>
                    <?php
                }
                ?>					
            </div><!--END CLASS m_profile_right PART -->
        </div><!--END CLASS m_profile PART -->
    </div><!--END CLASS form_class PART -->
</div><!--END CLASS contant PART -->
<!--<script type="text/javascript" language="javascript">
$( "#update_event" ).validate({
        rules: {
                buy_url: {
                        url: true
                }
        }
});
</script>-->
<?php include('../_includes/footer.php'); ?>



