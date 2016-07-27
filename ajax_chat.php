<?php
include('_includes/application-top.php');
extract($_POST);

$data = array(
    "from_id" => $from_id,
    "to_id" => $to_id,
    "msg" => $msg,
    "view_status" => 0
);
$table = "tbl_chat";
insertData($data, $table);

$query = mysqli_query($link,"SELECT tbl_chat.from_id,tbl_chat.*,tbl_users.id,tbl_users.username FROM tbl_chat LEFT JOIN tbl_users ON tbl_chat.from_id=tbl_users.id  WHERE from_id='" . $from_id . "'");
$row = mysqli_fetch_array($query);
?>

<label style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px; color:#FF9900;font-weight:bold;"><?php echo $row['username']; ?></label>:&nbsp;&nbsp;<label style="color:#999999;font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; font-size:14px; text-align:justify;"><?php echo $msg; ?></label><br />
