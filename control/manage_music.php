<?php
include('include/application_top.php');
cmslogin();
if (isset($_GET['id'])) {
    $sql = "delete from tbl_site_music where id='" . $_GET['id'] . "'";
    mysql_query($sql);
    unlink("../_uploads/site_music/" . $_GET['id'] . ".mp3");
    $MSG = "Music Record Deleted Sucessfully.";
}
?>
<?php include('include/header.php'); ?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
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
        }else if (isset($_GET['op']) AND ( $_GET['op'] == "add_music_success_4rm_media")) {
            echo "Music added to the playlist successfully.";
        }
        ?>
    </p>
    <p class="msg">
        <?php
        
        ?>
    </p>
<?php } ?>
<?php
//DATABASE QUERY
$result = mysql_query("SELECT * FROM  tbl_site_music order by id ");
$number = mysql_num_rows($result);
//$data=mysql_fetch_assoc($result);
// print_r($data);
?>

<p style="text-align:right; "><a href="add_site_music.php" class="button">Add Music</a></p>
<table border="1" class="TDContent" cellpadding="10" cellspacing="0" width="760px;">
    <h1>MANAGE MUSIC</h1>
    <?php
    if ($number <= 0) {
        ?>
        <p class="err"><?php echo "No Record Found!"; ?></p>
        <?php
    } else {
        ?>

        <tr>
            <th style="text-align:left;">Name</th>
            <th style="text-align:left;">Artist</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
    }
    while ($row = mysql_fetch_assoc($result)) {
        ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><?php echo $row["artist"]; ?></td>
            <td align="center"><?php if ($row['status'] == 1) { ?><p class="active"><?php echo 'Active'; ?></p><?php } else { ?><p class="inactive"><?php echo 'Inactive'; ?></p><?php } ?></td>
            <td align="center">
                <a id="audio" href="music_play.php?filename=../_uploads/site_music/<?php echo $row["id"]; ?>.mp3"><img src="../_images/mp3.png" title="Play Music"></a>
                <a href="edit_site_music.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo SITE_URL ?>images/Edit-32.png" title="Update Music" style="height:25px;"/></a>
                <a href="<?php echo "javascript:ConfrimMessage_Delete('manage_music.php?id=" . $row["id"] . "')"; ?>"><img src="../_images/del.png" title="Delete Music"></a>
            </td>
        </tr>				
        <?php
    }
    ?>

</table> 
<?php include('include/footer.php'); ?>
