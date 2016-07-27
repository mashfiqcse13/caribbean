<?php

include('../_includes/application-top.php');

/* $query = "DELETE FROM tbl_users WHERE id=".$_GET[id];
  $query_row = mysqli_query($link,$query);
  $img_location="../_uploads/user_photo/".$_GET['id'].".jpg";
  if(file_exists($img_location))
  {
  @unlink($img_location);
  } */


/* * *****************************************************************
  DELETE USER tbl_orders
 * ****************************************************************** */

$query1 = mysqli_query($link,"SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
					   p.id=tbl_orders.p_id WHERE tbl_orders.uid='" . $_GET['id'] . "' ORDER BY tbl_orders.id DESC");

while ($row = mysqli_fetch_assoc($query1)) {
    ?>
    <?php

    echo  //$row['o_id']; 


    /* $tbl_orders = "DELETE FROM  tbl_orders WHERE id='".$row['o_id']."'";
      $tbl_orders_row = mysqli_query($link,$tbl_orders); */
    ?>

    <?php

}
?>














<?php

/* * *****************************************************************
  DELETE USER Messages
 * ****************************************************************** */

$query_message = "SELECT tbl_msg.id AS m_id, tbl_msg.*,tbl_users.id AS tbl_user_id, tbl_users.first_name, tbl_users.last_name, tbl_users.type

				FROM tbl_msg LEFT OUTER JOIN tbl_users
			
				ON tbl_msg.from_id = tbl_users.id  WHERE tbl_msg.to_id ='" . $_GET['id'] . "'  ORDER BY tbl_msg.id DESC ";


$query_message_row = mysqli_query($link,$query_message);

while ($message_row = mysqli_fetch_assoc($query_message_row)) {
    ?>

    <?php

    //echo $message_row['to_id'];
    /* $delete_message = "DELETE FROM tbl_msg WHERE to_id='".$message_row['to_id']."'";
      $delete_message_row = mysqli_query($link,$delete_message); */
    ?>


    <?php

}

/* * *****************************************************************
  DELETE USER Images
 * ****************************************************************** */
$query_image = "SELECT * FROM tbl_profile_photos WHERE user_id='" . $_GET['id'] . "'";

$query_image_row = mysqli_query($link,$query_image);

while ($image_row = mysqli_fetch_assoc($query_image_row)) {
    ?>

    <?php

    // echo $image_row['id'];

    /* $img_location1="../_uploads/profile_photo/".$image_row['id'].".jpg";
      if(file_exists($img_location1))
      {
      @unlink($img_location1);
      }
      $img_location1="../_uploads/profile_photo/thumb/".$image_row['id'].".jpg";
      if(file_exists($img_location1))
      {
      @unlink($img_location1);
      }
      $image_delete_id = "DELETE FROM tbl_profile_photos WHERE id='".$image_row['id']."'";
      $query_image_row = mysqli_query($link,$image_delete_id); */
}
//header("Location:http://server/webdev/CarabianCircleStar/site/member/login.php");
?>
		