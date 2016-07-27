<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>
<!--/////MUSIC DELETE CONFIRM MESSAGE///////-->
<script type="text/javascript">
    function ConfrimMessage_Delete(Mid, Pid) //confarming property delete
    {

        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page

            var Url = "delete_music.php?id=" + Mid + "&pid=" + Pid;
            window.location = "" + Url;
        }
    }

    $(document).ready(function () {

        $('a#audio').fancybox();

        /*$("a#video").fancybox({
         'width'				: 400,
         'height'			: 580,
         'scrolling'		:	'no',
         'autoScale'			: true,
         'titlePosition'	: 'over',
         'transitionIn'		: 'none',
         'transitionOut'		: 'none'
         });*/
    });



</script>
<div class="content">
    <h1>Profile Music</h1>
    <?php
    if (isset($_GET['op'])) {
        ?>
        <p class="err">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
                echo "Music Record Deleted Sucessfully.";
            }
            ?>
        </p>
        <p class="msg">
            <?php
            if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
                echo "Music Record Edit sucessfully.";
            }
            ?>
        </p>
    <?php } ?>
    <p style="text-align:right"><a href="profile_setup.php" class="button" style="float:left; margin:-5px 0px 0px 0px;">Back</a><a href="add_mp3_music.php" class="button">Add Music</a></p>
    <!--/////USER MUSIC UPLOAD HEAR/////-->
    <?php
    $result = mysqli_query($link,"SELECT * FROM  tbl_profile_music WHERE 	user_id='" . $_SESSION['talent_id'] . "' order by id DESC ");
    $number = mysqli_num_rows($result);
    //$data=mysqli_fetch_assoc($result);
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
                    <th style="text-align:left;">Music Title</th>
                    <th style="text-align:left;">Additional Notes</th>
                    <th>Saleable</th>
                    <th>Price</th>
                    <th align="center">Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
            }
            while ($row = mysqli_fetch_assoc($result)) {
                $sql = mysqli_query($link,"SELECT * FROM  tbl_products WHERE ref_id='" . $row['id'] . "' AND content_type=1 ");
                $res = mysqli_fetch_assoc($sql);
                $row1 = mysqli_num_rows($sql);

                if ($res['id'] != '') {
                    $pid = $res['id'];
                } else {
                    $pid = 0;
                }
                ?>
                <tr>
                    <td><?php echo $row["music_title"]; ?></td>
                    <td><?php echo substr($row["music_details"], 0, 30); ?></td>
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
                    <td align="center">
                        <a id="audio" href="music_play.php?filename=../_uploads/profile_music/<?php echo $row["id"]; ?>.mp3">
                            <img src="../_images/mp3.png" title="Play Music">
                        </a>
                        <a href="update_mp3_music.php?id=<?php echo $row["id"]; ?>">
                            <img src="../_images/Edit.png" title="Update Music">
                        </a>
                        <a href="javascript:" onclick="ConfrimMessage_Delete(<?php echo $row['id']; ?>, <?php echo $pid; ?>)">
                            <img src="../_images/del.png" title="Delete Music">
                        </a>
                    </td>
                </tr>				
    <?php
}
?>
        </tbody>				
    </table> 
</div>
<?php
include('../_includes/footer.php');
?>
