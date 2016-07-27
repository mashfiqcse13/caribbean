<?php
include('_includes/application-top.php');
extract($_POST);

$row = mysqli_query($link,"SELECT tbl_chat.*,tbl_users.id AS t_u_id,tbl_users.username FROM tbl_chat LEFT JOIN tbl_users ON tbl_chat.to_id=tbl_users.id  WHERE  tbl_chat.to_id='" . $to_id . "' AND view_status=0");

while ($data = mysqli_fetch_array($row)) {
    ?>



    <?php
    $str = "SELECT username FROM tbl_users WHERE id='" . $data['from_id'] . "'";

    $friend_query = mysqli_query($link,$str);
    $friend_data = mysqli_fetch_assoc($friend_query);

    $user = $friend_data['username'];
    ?>

    <label style="font-family:Verdana, Arial, Helvetica, sans-serif;font-size:14px; color:#FF9900;font-weight:bold;"><?php echo $user; ?></label>:&nbsp;&nbsp;<label style="color:#999999;font-family:Verdana, Arial, Helvetica, sans-serif;font-weight:bold; font-size:14px; text-align:justify;"><?php echo $data['msg']; ?></label><br />


    <?php
    //update view status		
    $sql = "UPDATE  tbl_chat SET  view_status =  '1' WHERE  tbl_chat.id =" . $data['id'];
    mysqli_query($link,$sql);
}
?>

