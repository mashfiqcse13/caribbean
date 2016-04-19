<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>

<?php
//3.perform database query

if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "delete") {
    $db_rslt_file_name = mysql_query("SELECT * FROM tbl_contact WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "'");
    $file_name_4_dlt = mysql_fetch_array($db_rslt_file_name);
    $file_name_4_dlt = '../' . $file_name_4_dlt['file_attached'];
    unlink($file_name_4_dlt);
    mysql_query("DELETE FROM `tbl_contact` WHERE `id` = '" . mysql_real_escape_string($_REQUEST['id']) . "';");
    echo "<h3 style='padding: 9px;text-align: center;color: #ffffff;background: #008000;'>Record Successfully Deleted,</h1>";
}



$result = mysql_query("SELECT * FROM tbl_contact");
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
    <h1>Contact Form Page Listing</h1>
    <tr>
        <th style="text-align:left;">Name</th>
        <th style="text-align:left;">Email</th>
        <th>Company</th>
        <th>Job Title</th>
        <th>Query Subject</th>
        <th>Query</th>
        <th>Attached File</th>
        <th>Date</th>
        <th>Time</th>
        <th>Action</th>
    </tr>
    <?php
    while ($row = mysql_fetch_array($result)) {
        ?>
        <tr>
            <td><?php echo $row["name"]; ?></td>
            <td><a href="mailto:<?php echo trim($row["email"]); ?>"> <?php echo $row["email"]; ?></a></td>
            <td><?php echo $row["company"]; ?></td>
            <td><?php echo $row["job_title"]; ?></td>
            <td><?php echo $row["query_subject"]; ?></td>
            <td><?php echo $row["query"]; ?></td>
            <td>

                <?php
                if (!empty($row['file_attached'])) {
                    ?>
                    <a href="<?php echo "http://" . $_SERVER['HTTP_HOST'] . "/control/media.php?id=" . $row['id']; ?>" >View It !!</a>
                    <?php
                } else {
                    echo "No File found";
                }
                ?>
            </td>
            <td><?php echo $row["join_date"]; ?></td>
            <td><?php echo $row["join_time"]; ?></td>
            <td align="center"><a href="contact_record.php?id=<?php echo $row["id"]; ?>&action=delete">Delete</a></td>
        </tr>
        <?php
    }
    ?>
</table>
<?php include('include/footer.php'); ?>
