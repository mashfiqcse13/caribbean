<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>

<?php
//3.perform database query
$result = mysqli_query($link,"SELECT * FROM tbl_cms");
if (!$result) {
    die("database query faild:" . mysqli_error($link));
}
?>
<?php
if (isset($_GET['op']) AND ( $_GET['op'] == "U")) {
    echo "<p  style=margin-left:15px;color:#669900;>Record Updated Sucessfully</p>";
} elseif (isset($_GET['op']) AND ( $_GET['op'] == "invalid")) {
    echo "Invalid Login";
}
?>

<table border="1" class="TDContent" cellpadding="10" cellspacing="0" width="760px;">
    <h1>CONTENT MANAGEMENT SYSTEM</h1>
    <tr>
        <th style="text-align:left;">Name</th>
        <th style="text-align:left;">Heading</th>
        <th>Status</th>	
        <th>Action</th>
    </tr>
    <?php
    while ($row = mysqli_fetch_array($result)) {
        if ($row["status"] == 0) {
            $status = "<p style=color:#FF0000;>InActive</p>";
        }
        if ($row["status"] == 1) {
            $status = "<p style=color:#66CC00;>Active</p>";
        }
        if ($row["name"] == "Donate" || $row["name"] == "Contact" || $row["name"] == "Forum") {
            
        } else {
            ?>
            <tr>			
                <td><?php echo $row["name"]; ?></td>
                <td><?php echo $row["heading"]; ?></td>
                <td><?php echo $status; ?></td>		
                <td align="center"><a href="edit_cms.php?id=<?php echo $row["id"]; ?>"><img src="<?php echo SITE_URL ?>images/Edit-32.png" /></a></td>	
            </tr>
            <?php
        }
    }
    ?>
</table>
<?php include('include/footer.php'); ?>
