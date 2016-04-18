<?php

include('_includes/application-top.php');
$uid = $_POST['uid'];
$cid = $_POST['cid'];
$comm = mysql_real_escape_string($_POST['txt']);

$update_comments = mysql_query("update tbl_profile_comments set comment_text = '$comm' where id='$cid' and commenter_id = '$uid'");

if ($update_comments) {
    echo "1";
}
?>