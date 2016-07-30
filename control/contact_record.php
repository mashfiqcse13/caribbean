<?php
include('include/application_top.php');
cmslogin();
include('include/header.php');
//3.perform database query

if (!empty($_REQUEST['id']) && $_REQUEST['action'] == "delete") {
    $db_rslt_file_name = mysqli_query($link, "SELECT * FROM tbl_contact WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "'");
    $file_name_4_dlt = mysqli_fetch_array($db_rslt_file_name);
    $file_name_4_dlt = '../' . $file_name_4_dlt['file_attached'];
    if (file_exists($file_name_4_dlt)) {
        unlink($file_name_4_dlt);
    }
    mysqli_query($link, "DELETE FROM `tbl_contact` WHERE `id` = '" . mysqli_real_escape_string($link, $_REQUEST['id']) . "';");
    header('Location: contact_record.php?msq_code=deleted');
    die();
}

if (!empty($_REQUEST['msq_code']) && $_REQUEST['msq_code'] == "deleted") {
    ?>  <script>alert("Record Successfully Deleted")</script> <?php
}



$result = mysqli_query($link, "SELECT * FROM tbl_contact");
if (!$result) {
    die("database query faild:" . mysqli_error($link));
}
?>
<?php
if (isset($_GET['op']) AND ( $_GET['op'] == "U")) {
    ?> <script>alert("Record Updated Sucessfully")</script> <?php
} elseif (isset($_GET['op']) AND ( $_GET['op'] == "invalid")) {
    ?> <script>alert("Invalid Login")</script> <?php
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
    while ($row = mysqli_fetch_array($result)) {
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
                    // file separation buttons
                    $file_type_id = array(
                        'Video' => 0,
                        'Photo' => 1,
                        'Music' => 2,
                        'Document' => 3,
                        'Archive' => 4,
                    );
                    $file_type_id = $file_type_id[$row['type_of_file']];
                    echo '<a href="' . SITE_URL . 'media.php?id=' . $row['id'] . '&filetype=' . $file_type_id . '" >View It !!</a>';
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
