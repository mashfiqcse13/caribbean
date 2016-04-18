<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
if (isset($_GET['id'])) {

    $data = getAnyTableWhereData("tbl_profile_videos", "AND id=" . $_GET['id'] . " ");

    if ($data['video_type'] == 0) {
        $sql = "delete from tbl_profile_videos where id='" . $_GET['id'] . "'";
        mysql_query($sql);
        unlink("../_uploads/video_photo/" . $_GET['id'] . ".jpg");
        $MSG = "Video Record Deleted Sucessfully.";
    } else {
        $sql = "delete from tbl_profile_videos where id='" . $_GET['id'] . "'";
        mysql_query($sql);
        unlink("../_uploads/profile_video/" . $_GET['id'] . ".mp4");
        unlink("../_uploads/video_photo/" . $_GET['id'] . ".jpg");
        $MSG = "Video Record Deleted Sucessfully.";
    }
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_loin').validate();
    });

    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }

    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'scrolling': 'no',
            'autoScale': true,
            'titlePosition': 'over',
            'transitionIn': 'none',
            'transitionOut': 'none'
        });
    });
</script>
<div class="content"><!--START CLASS contant PART -->
    <h1>Profile Video</h1>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "Video Record Edit sucessfully.";
            }
            ?>
        </p>
        <?php
    }
    if (isset($MSG)) {
        ?>
        <p class="err">
            <?php
            if (isset($MSG) AND ( $MSG <> "")) {
                echo $MSG;
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><a href="add_video.php" class="button">Add Video</a></p>
    <!--/////USER VIDEO UPLOAD HEAR/////-->
    <?php
    //DATABASE QUERY
    $result = mysql_query("SELECT * FROM  tbl_profile_videos WHERE 	user_id='" . $_SESSION['user_id'] . "'  order by id ");
    $number = mysql_num_rows($result);
    //$data=mysql_fetch_assoc($result);
    // print_r($data);
    ?>
    <table cellpadding="0" cellspacing="0" class="TabUIRecords" width="100%">
        <?php
        if ($number <= 0) {
            ?>
            <p class="err"><?php echo "No Record Found!"; ?></p>
            <?php
        } else {
            ?>
            <thead>
                <tr>
                    <td align="center">Photo</td>
                    <td style="text-align:left;">Name</td>
                    <td align="center">Type</td>
                    <td align="center">Status</td>
                    <td align="center">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysql_fetch_assoc($result)) {
                ?>
                <tr>
                    <td width="8%">
                        <a id="video" <?php if ($row["video_type"] == 1) { ?>href="video_play.php?filename=../_uploads/profile_video/<?php echo $row["id"]; ?>.mp4" <?php } else {
                    ?> href="video_play.php?id=<?php echo $row["id"];
                   }
                ?>" >
                            <img src="../_uploads/video_photo/<?php echo $row["id"]; ?>.jpg" title="Play Video"/>
                        </a>
                    </td>
                    <td><?php echo $row["video_name"]; ?></td>
                    <td align="center"><?php
                        if ($row["video_type"] == 1) {
                            echo 'File';
                        } else {
                            echo 'You Tube';
                        }
                        ?></td>
                    <td align="center"><?php
                        if ($row['status'] == 1) {
                            echo 'Active';
                        } else {
                            echo 'Inactive';
                        }
                        ?></td>
                    <td align="center">
                        <a id="video" <?php if ($row["video_type"] == 1) { ?>href="video_play.php?filename=../_uploads/profile_video/<?php echo $row["id"]; ?>.mp4" <?php } else {
                           ?> href="video_play.php?id=<?php echo $row["id"];
                       }
                        ?>" ><img src="../_images/play.png" title="Play Video"></a>
                        <a href="update_video.php?id=<?php echo $row["id"]; ?>"><img src="../_images/Edit.png" title="Update Video"></a>
                        <a href="<?php echo "javascript:ConfrimMessage_Delete('manage_video.php?id=" . $row["id"] . "')"; ?>"><img src="../_images/del.png" title="Delete Video"></a>
                    </td>
                </tr>				
    <?php
}
?>
        </tbody>  	
    </table> 
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
