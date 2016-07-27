<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_GET['id'])) && ($_GET['id'] != '')) {

    $data = getAnyTableWhereData("tbl_profile_videos", "AND id=" . $_GET['id'] . " ");

    if ($data['video_type'] == 0) {

        $sql = "delete from tbl_profile_videos where id='" . $_GET['id'] . "'";
        mysqli_query($link,$sql);
        unlink("../_uploads/video_photo/" . $_GET['id'] . ".jpg");
        $MSG = "Video Record Deleted Sucessfully.";
    } else {


        if ((isset($_GET['id'])) && ($_GET['id'] != '')) {

            if ($_GET['pid'] != 0) {

                $sql1 = "delete from tbl_products where id='" . $_GET['pid'] . "'";
                mysqli_query($link,$sql1);

                unlink("../_uploads/profile_product/" . $_GET['pid'] . ".jpg");
                unlink("../_uploads/profile_product/thumb/" . $_GET['pid'] . ".jpg");


                $sql = "delete from tbl_profile_videos where id='" . $_GET['id'] . "'";
                mysqli_query($link,$sql);
                unlink("../_uploads/profile_video/" . $_GET['id'] . ".mp4");
                unlink("../_uploads/video_photo/" . $_GET['id'] . ".jpg");

                $MSG = "Video Record Deleted Sucessfully.";
            } else {

                $sql = "delete from tbl_profile_videos where id='" . $_GET['id'] . "'";
                mysqli_query($link,$sql);
                unlink("../_uploads/profile_video/" . $_GET['id'] . ".mp4");
                unlink("../_uploads/video_photo/" . $_GET['id'] . ".jpg");
                $MSG = "Video Record Deleted Sucessfully.";
            }
        }
    }
}
include('../_includes/header.php');
?> 
<script type="text/javascript">
    $(document).ready(function () {
        $('#talents_loin').validate();
    });

    function ConfrimMessage_Delete(Mid, Pid) //confarming property delete
    {

        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page

            var Url = "manage_video.php?id=" + Mid + "&pid=" + Pid;
            window.location = "" + Url;
        }
    }

    $(document).ready(function () {
        $("a#video").fancybox({
            'width': 400,
            'height': 580,
            'transitionIn': 'elastic',
            'transitionOut': 'elastic',
            'speedIn': 600,
            'speedOut': 200,
            'overlayShow': false
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
    $result = mysqli_query($link,"SELECT * FROM  tbl_profile_videos WHERE 	user_id='" . $_SESSION['talent_id'] . "'  order by id desc");
    $number = mysqli_num_rows($result);
    //$data=mysqli_fetch_assoc($result);
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
                    <th>Saleable</th>
                    <th>Price</th>
                    <th>Shipping</th>
                    <td align="center">Status</td>
                    <td align="center">Action</td>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysqli_fetch_assoc($result)) {

                $sql = mysqli_query($link,"SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' AND content_type=2 ");
                $res = mysqli_fetch_assoc($sql);

                $row1 = mysqli_num_rows($sql);

                if ($res['id'] != '') {
                    $pid = $res['id'];
                } else {
                    $pid = 0;
                }
                ?>
                <tr>
                    <td width="8%">
                        <a id="video" <?php if ($row["video_type"] == 1) { ?>href="video_play.php?filename=../_uploads/profile_video/<?php echo $row["id"]; ?>.mp4" <?php } else {
                    ?> href="video_play.php?id=<?php
                               echo $row["id"];
                           }
                           ?>" >
                            <img src="../_uploads/video_photo/<?php echo $row["id"]; ?>.jpg" width="150" title="Play Video"/>
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
                        if ($row1 == 1) {
                            echo "Yes";
                        } else {
                            echo "No";
                        }
                        ?></td>
                    <td align="center"><?php
                        if ($row1 == 0) {
                            echo "_";
                        } else {
                            echo "$" . $res['product_price'];
                        }
                        ?></td>
                    <td align="center"><?php
                        if ($row1 == 0) {
                            echo "_";
                        } else {
                            echo "$ " . $res['p_shipping'];
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
                            ?> href="video_play.php?id=<?php
                               echo $row["id"];
                           }
                           ?>" ><img src="../_images/play.png" title="Play Video"></a>
                        <a href="update_video.php?id=<?php echo $row["id"]; ?>">
                            <img src="../_images/Edit.png" title="Update Video">
                        </a>
                        <a href="javascript:" onclick="ConfrimMessage_Delete(<?php echo $row['id']; ?>, <?php echo $pid; ?>)">
                            <img src="../_images/del.png" title="Delete Video">
                        </a>
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
