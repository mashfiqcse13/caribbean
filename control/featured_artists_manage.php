<?php
include('include/application_top.php');
cmslogin();
if (isset($_GET['id'])) {
    $sql = "delete from tbl_featured_artists where id='" . $_GET['id'] . "'";
    mysqli_query($link,$sql);
    unlink("../_uploads/featured_artists/" . $_GET['id'] . ".jpg");
    header("Location:featured_artists_manage.php?op=del");
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
</script>

<?php
if (isset($_GET['op'])) {
    ?>
    <p class="err">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
            echo "Featured Artists Record Deleted Sucessfully.";
        }
        ?>
    </p>
    <p class="msg">
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "u")) {
            echo "Featured Artists Record Edit sucessfully.";
        }
        if (isset($_GET['op']) AND ( $_GET['op'] == "a")) {
            echo "Featured Artists Photo Added sucessfully.";
        }
        ?>
    </p>
<?php } ?>
<?php
//DATABASE QUERY
$result = mysqli_query($link,"SELECT * FROM  tbl_featured_artists order by id ");
$number = mysqli_num_rows($result);
//$data=mysqli_fetch_assoc($result);
// print_r($data);
?>
<p style="text-align:right; "><a href="add_featured_artists_photo.php" class="button">Add Featured Artists</a></p>
<table border="1" class="TDContent" cellpadding="10" cellspacing="0" width="760px;">
    <h1>MANAGE FEATURED ARTISTS</h1>
    <?php
    if ($number <= 0) {
        ?>
        <p class="err"><?php echo "No Record Found!"; ?></p>
        <?php
    } else {
        ?>

        <tr>
            <th style="text-align:left;">Photo</th>
            <th>Artist's Name</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php
    }
    while ($row = mysqli_fetch_assoc($result)) {
        ?>
        <tr>
            <td width="8%"><img src="../_uploads/featured_artists/<?php echo $row["id"]; ?>.jpg" style=""/></td>
            <td align="center"><?php echo $row["f_artists_name"]; ?></td>
            <td align="center"><?php if ($row['status'] == 1) { ?><p class="active"><?php echo 'Active'; ?></p><?php } else { ?><p class="inactive"><?php echo 'Inactive'; ?></p><?php } ?></td>
            <td align="center">
                <a href="edit_featured_artists.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo SITE_URL ?>images/Edit-32.png" title="Update Music" style="height:25px;"/></a>
                <a href="<?php echo "javascript:ConfrimMessage_Delete('featured_artists_manage.php?id=" . $row["id"] . "')"; ?>"><img src="../_images/del.png" title="Delete Music"></a>
            </td>
        </tr>				
        <?php
    }
    ?>

</table> 
<?php include('include/footer.php'); ?>
