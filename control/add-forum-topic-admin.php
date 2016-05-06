<?php
include('../_includes/application-top.php');


include '../_includes/class.database.php';
include '../_includes/class.media.php';
$db = new DBClass(db_host, db_username, db_passward, db_name);
//CheckLoginForum();
//echo $_SESSION['user_id'];
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Add Topic')) {
    /* if(isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] !='') {
      $uid = $_SESSION['talent_id'];
      }elseif(isset($_SESSION['user_id']) AND $_SESSION['user_id'] != ''){
      $uid = $_SESSION['user_id'];
      }else{
      $uid ="0";//This is for admin
      } */

    $uid = "0"; //This is for admin
    if ((isset($_POST['forum_details'])) && ($_POST['forum_details'] != '')) {
        $data = array(
            "uid" => $uid,
            "forum_topic" => mysql_real_escape_string(trim($_POST['forum_topic'])),
            "forum_details" => mysql_real_escape_string(trim($_POST['forum_details'])),
            "view_count" => '0',
            "is_admin" => 'Yes'
        );
        $table = "tbl_forum_topics";
        insertData($data, $table);

        /* Added Activity Below */

        $uname = ("admin"); // for admin
        SaveActivity(11, $uname, mysql_real_escape_string(trim($_POST['forum_topic'])), $uid);

//////////////////////////////////////////////////


        $MSG = 'Your Topic Added sucessfully.';
    } else {
        $MSG1 = "Please Enter Details To Submit Your Topic !";
    }
}
include('../_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#add_forum').validate();

    });

</script>
<script type="text/javascript">
    /*CKEDITOR.replace( 'description');
     CKEDITOR.on("instanceReady", function(event)
     {
     $("#add_forum").validate(
     { rules: { title: {required: true}, description: {required: true}, stuff: {required: true} } });
     });*/
</script>

<div class="content">
    <h1>Add Topic</h1>
    <?php
    if (isset($MSG)) {
        ?>
        <p class="msg">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
        </p>
        <?php
    }
    if (isset($MSG1)) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG1) AND ( $MSG1 <> "")) {
                echo $MSG1;
            }
            ?>
        </p>
    <?php }
    ?>
    <p style="text-align:right"><a href="forum_record.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a></p><br />
    <div style="width:70%;">
        <div class="form_class">
            <form name="frm" action="<?php echo $_SERVER['PHP_SELF']; ?>"method="post" id="add_forum">
                <p>
                    <label for="email">Topic:</label>
                    <input  type="text" name="forum_topic" value="" maxlength="100" class="required" />
                </p>
                <a href="#media" id="add_media_button" class="button">Select Media</a>
                <br>

                <label style="vertical-align:top;">Details:</label>
                <textarea name="forum_details" id="editor" class="required"></textarea>
                <p class="img_warning">Note: Photo should be no longer than 300 height.</p>
                <script type="text/javascript">
                    // This call can be placed at any point after the
                    // <textarea>, or inside a <head><script> in a
                    // window.onload event handler.
                    // Replace the <textarea id="editor"> with an CKEditor
                    // instance, using default configurations.
                    CKEDITOR.replace('editor');
                </script><br/><br/>
                <input type="hidden" name="media_id"/>
                <input type="submit" name="submit" value="Add Topic" class="button" />
            </form>
        </div>
    </div>
</div>
<!--Media items content are here-->
<div style="display:none">
    <div id="media">
        <style>
            #add_media_button {margin: 0 0 20px 140px;display: inline-block;}
            #media{margin: 10px 0;}
            #media li{display: inline-block;}
            #media > ul{padding: 0;margin: 0;}
            #media li{display: inline-block; margin: 10px 3px;}
            #media table { padding: 5px;}
            #media li:hover,#media li.selected{background-color:#F1F1F1;}
        </style>
        <ul>
            <?php
            $media = new media();
            $media_rows = $media->get_all_media_as_array('pic_music_vedio');
            foreach ($media_rows as $key => $media_row) {
                ?>
                <li class="media_item" data-media-id="<?php echo $media_row['id'] ?>">
                    <?php
                    if ($media_row['type_of_file'] == 'Music') {
                        ?>

                        <audio  width="100%" src="<?php echo BASE_URL . $media_row['file_attached']; ?>" type="audio/mp3" controls="controls"></audio>
                        <?php
                    } else if ($media_row['type_of_file'] == 'Photo') {
                        ?>

                        <img  width="300" height="200" src="<?php echo BASE_URL . $media_row['file_attached']; ?>" />
                        <?php
                    } else if ($media_row['type_of_file'] == 'Video') {
                        ?> 
                        <video width="300" height="200" controls="">
                            <source src="<?php echo BASE_URL . $media_row['file_attached']; ?>" type="video/mp4">
                            Your browser does not support the video tag.
                        </video> 
                        <?php
                    }
                    ?>
                    <table>
                        <tr>
                            <td>Title Of Work</td>
                            <td>:</td>
                            <td><?php echo $media_row['title_of_work'] ?></td>
                        </tr>
                        <tr>
                            <td>Artist</td>
                            <td>:</td>
                            <td><?php echo $media_row['artistbandname'] ?></td>
                        </tr>
                        <tr>
                            <td>Genre</td>
                            <td>:</td>
                            <td><?php echo $media_row['genre'] ?></td>
                        </tr>
                        <tr>
                            <td>Posted by</td>
                            <td>:</td>
                            <td><?php echo $media_row['name'] ?></td>
                        </tr>
                        <tr>
                            <td>Company</td>
                            <td>:</td>
                            <td><?php echo $media_row['company'] ?></td>
                        </tr>
                        <tr>
                            <td>Email</td>
                            <td>:</td>
                            <td><?php echo $media_row['email'] ?></td>
                        </tr>
                        <tr>
                            <td>Created On</td>
                            <td>:</td>
                            <td><?php echo "{$media_row['join_date']} {$media_row['join_time']}" ?></td>
                        </tr>
                        <tr>
                            <td>Media id</td>
                            <td>:</td>
                            <td><?php echo $media_row['id'] ?></td>
                        </tr>
                    </table>

                </li>

            <?php } ?>
        </ul>

    </div>
</div>
<script type="text/javascript">
    if (!String.prototype.trim) {
        String.prototype.trim = function () {
            var c;
            for (var i = 0; i < this.length; i++) {
                c = this.charCodeAt(i);
                if (c == 32 || c == 10 || c == 13 || c == 9 || c == 12)
                    continue;
                else
                    break;
            }
            for (var j = this.length - 1; j >= i; j--) {
                c = this.charCodeAt(j);
                if (c == 32 || c == 10 || c == 13 || c == 9 || c == 12)
                    continue;
                else
                    break;
            }
            return this.substring(i, j + 1);
        };
    }

    $("form").submit(function () {
        var messageLength = CKEDITOR.instances['editor'].getData().replace(/<[^>]*>/gi, '').trim().length;
        if (!messageLength) {
            alert('Please Enter Details To Submit Your Topic!');
            document.getElementById('editor').focus();
            return false;
        }
        return true;
    });

    // for media section in the form
    $("a#add_media_button").fancybox();

    //For selecting a media
    $('.media_item').click(function () {
        $('.media_item').removeClass('selected');
        var selected_media_id = $(this).attr('data-media-id');
        $('[name="media_id"]').val(selected_media_id);
        $(this).addClass('selected');
    });

</script>
<?php
include('../_includes/footer.php');
