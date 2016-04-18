<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>

<?php
//3.perform database query

if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "delete") {
    mysql_query("DELETE FROM `tbl_donate` WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "';");
    echo "<h3 style='padding: 20px;text-align: center;color: #ffffff;background: #008000;'>Record Successfully Deleted,</h1>";
}



$result = mysql_query("SELECT * FROM tbl_donate");
if (!$result) {
    die("database query faild:" . mysql_query());
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
    <h1>Donate Form Page Listing</h1>
    <tr>
        <th style="text-align:left;">Name</th>
        <th style="text-align:left;">Email</th>
        <th>Amount</th>
        <th>Message</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
    </tr>
    <?php
    while ($row = mysql_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><a href="mailto:<?php echo $row["email"]; ?>"><?php echo $row["email"]; ?></a></td>
            <td><?php echo $row["amount"]; ?></td>
            <td><?php echo $row["message"]; ?></td>
            <td><?php echo $row["join_date"]; ?></td>
            <td><?php echo $row["join_time"]; ?></td>
            <td align="center"><a href="donate_record.php?id=<?php echo $row["id"]; ?>&action=delete">Delete</a></td>
        </tr>
        <?php
    }
    ?>
</table>
<?php include('include/footer.php'); ?>
