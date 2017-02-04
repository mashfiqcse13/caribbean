<?php

include('include/application_top.php');
cmslogin();

/* * *****************************************************************
  DELETE USER orders
 * ****************************************************************** */

$query = "SELECT * FROM tbl_users WHERE id='" . $_GET['id'] . "'";
$query_result = mysqli_query($link, $query);
    
$row = mysqli_fetch_array($query_result);

$uid = $row['type'];


$query1 = mysqli_query($link,"SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
					   p.id=tbl_orders.p_id WHERE tbl_orders.uid='" . $_GET['id'] . "' ORDER BY tbl_orders.id DESC");

if (mysqli_num_rows($query1) > 0) {
    while ($row = mysqli_fetch_assoc($query1)) {
        $tbl_order_shipping = "SELECT * FROM tbl_order_shipping WHERE order_id='" . $row['o_id'] . "'";

        $query_tbl_order_shipping = mysqli_query($link,$tbl_order_shipping);

        $order_shipping_row = mysqli_fetch_array($query_tbl_order_shipping);

        //echo $order_shipping_row['order_id'];


        $delete_tbl_order_shipping = "DELETE FROM  tbl_order_shipping WHERE order_id='" . $row['o_id'] . "'";
        $tbl_order_shipping_row = mysqli_query($link,$delete_tbl_order_shipping);

        $tbl_orders = "DELETE FROM  tbl_orders WHERE id='" . $row['o_id'] . "'";
        $tbl_orders_row = mysqli_query($link,$tbl_orders);
    }
}

/* * *****************************************************************
  DELETE USER order_manage
 * ****************************************************************** */
$query_order_manage = "SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id AS prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON tbl_orders.p_id = p.id 
							WHERE tbl_orders.seller_id ='" . $_GET['id'] . "' ORDER BY tbl_orders.id DESC";

$order_manage_row = mysqli_query($link,$query_order_manage);

if (mysqli_num_rows($order_manage_row) > 0) {

    while ($order_row = mysqli_fetch_array($order_manage_row)) {
        $orders_manage = "DELETE FROM  tbl_orders WHERE id='" . $order_row['o_id'] . "'";
        $orders_manage_row = mysqli_query($link,$orders_manage);

        $delete_orders_manage = "DELETE FROM  tbl_order_shipping WHERE order_id='" . $order_row['o_id'] . "'";
        $orders_manage_row = mysqli_query($link,$delete_orders_manage);
    }
}


/* * *****************************************************************
  DELETE USER tbl_forum_topics
 * ****************************************************************** */
$forum_topics = "SELECT * FROM tbl_forum_topics WHERE uid='" . $_GET['id'] . "'";

$query_forum_topics = mysqli_query($link,$forum_topics);

if (mysqli_num_rows($query_forum_topics) > 0) {

    while ($forum_topics_row = mysqli_fetch_array($query_forum_topics)) {

        $delete_forum_topics = "DELETE FROM  tbl_forum_topics WHERE id='" . $forum_topics_row['id'] . "'";
        $query_forum_topics_row = mysqli_query($link,$delete_forum_topics);
    }
}

/* * *****************************************************************
  DELETE USER tbl_forum_reply
 * ****************************************************************** */
$query_forum_reply = "SELECT * FROM tbl_forum_reply WHERE uid='" . $_GET['id'] . "'";

$forum_reply_row = mysqli_query($link,$query_forum_reply);

if (mysqli_num_rows($forum_reply_row) > 0) {

    while ($forum_row = mysqli_fetch_array($forum_reply_row)) {
        $delete_forum_reply = "DELETE FROM  tbl_forum_reply WHERE id='" . $forum_row['id'] . "'";
        $forum_reply_row = mysqli_query($link,$delete_forum_reply);
    }
}

/* * *****************************************************************
  DELETE USER tbl_fans
 * ****************************************************************** */
$tbl_fans = "SELECT * FROM tbl_fans WHERE profile_id='" . $_GET['id'] . "' OR fan_id='" . $_GET['id'] . "'";

$query_fans = mysqli_query($link,$tbl_fans);

if (mysqli_num_rows($query_fans) > 0) {

    while ($tbl_fans_row = mysqli_fetch_array($query_fans)) {
        $delete_tbl_fans = "DELETE FROM  tbl_fans WHERE id='" . $tbl_fans_row['id'] . "'";
        $query_tbl_fans_row = mysqli_query($link,$delete_tbl_fans);
    }
}

/* * *****************************************************************
  DELETE USER Messages
 * ****************************************************************** */

$query_message = "SELECT tbl_msg.id AS m_id, tbl_msg.*,tbl_users.id AS tbl_user_id, tbl_users.first_name, tbl_users.last_name, tbl_users.type

			FROM tbl_msg LEFT OUTER JOIN tbl_users
		
			ON tbl_msg.from_id = tbl_users.id  WHERE tbl_msg.to_id ='" . $_GET['id'] . "'  ORDER BY tbl_msg.id DESC ";


$query_message_row = mysqli_query($link,$query_message);

if (mysqli_num_rows($query_message_row) > 0) {

    while ($message_row = mysqli_fetch_assoc($query_message_row)) {
        $delete_message = "DELETE FROM tbl_msg WHERE to_id='" . $message_row['to_id'] . "'";
        $delete_message_row = mysqli_query($link,$delete_message);
    }
}

/* * *****************************************************************
  DELETE USER UPLOAD Images
 * ****************************************************************** */
$query_image = "SELECT * FROM tbl_profile_photos WHERE user_id='" . $_GET['id'] . "'";

$query_image_row = mysqli_query($link,$query_image);

if (mysqli_num_rows($query_image_row) > 0) {

    while ($image_row = mysqli_fetch_assoc($query_image_row)) {
        /*         * *****************************************************************
          DELETE USER Products_Images
         * ****************************************************************** */


        $tbl_products = "SELECT * FROM tbl_products WHERE uid='" . $image_row['user_id'] . "' AND ref_id='" . $image_row['id'] . "' AND content_type='3'";

        $query_tbl_products = mysqli_query($link,$tbl_products);

        $tbl_products_row = mysqli_fetch_array($query_tbl_products);

        //echo $tbl_products_row['ref_id'].'<br>';
        //echo $tbl_products_row['id'];

        $img_location2 = "../_uploads/profile_product/" . $tbl_products_row['id'] . ".jpg";
        if (file_exists($img_location2)) {
            @unlink($img_location2);
        }
        $img_location2 = "../_uploads/profile_product/thumb/" . $tbl_products_row['id'] . ".jpg";
        if (file_exists($img_location2)) {
            @unlink($img_location2);
        }
        $delete_tbl_products = "DELETE FROM tbl_products WHERE id='" . $tbl_products_row['id'] . "'";
        $delete_tbl_products_row = mysqli_query($link,$delete_tbl_products);



        /*         * *****************************************************************
          DELETE USER profile_photo
         * ****************************************************************** */

        $img_location1 = "../_uploads/profile_photo/" . $image_row['id'] . ".jpg";
        if (file_exists($img_location1)) {
            @unlink($img_location1);
        }
        $img_location1 = "../_uploads/profile_photo/thumb/" . $image_row['id'] . ".jpg";
        if (file_exists($img_location1)) {
            @unlink($img_location1);
        }
        $image_delete_id = "DELETE FROM tbl_profile_photos WHERE id='" . $image_row['id'] . "'";
        $query_image_row = mysqli_query($link,$image_delete_id);
    }
}

/* * *****************************************************************
  DELETE USER music_mp3
 * ****************************************************************** */

$profile_music = "SELECT * FROM tbl_profile_music WHERE user_id='" . $_GET['id'] . "'";

$query_profile_music = mysqli_query($link,$profile_music);

if (mysqli_num_rows($query_profile_music) > 0) {

    while ($profile_music_row = mysqli_fetch_array($query_profile_music)) {
        $tbl_products_music = "SELECT * FROM tbl_products WHERE uid='" . $profile_music_row['user_id'] . "' AND ref_id='" . $profile_music_row['id'] . "' AND content_type='1'";

        $query_tbl_products_music = mysqli_query($link,$tbl_products_music);

        $tbl_products_row_music = mysqli_fetch_array($query_tbl_products_music);

        //echo $tbl_products_row_music['id'];

        $delete_tbl_products_music = "DELETE FROM tbl_products WHERE id='" . $tbl_products_row_music['id'] . "'";
        $delete_tbl_products_music_row = mysqli_query($link,$delete_tbl_products_music);


        $delete_music_row = "DELETE FROM tbl_profile_music WHERE id='" . $profile_music_row['id'] . "'";
        $query_music_row = mysqli_query($link,$delete_music_row);

        $music_mp3 = "../_uploads/profile_music/" . $profile_music_row['id'] . ".mp3";
        if (file_exists($music_mp3)) {
            @unlink($music_mp3);
        }
    }
}

/* * *****************************************************************
  DELETE USER video
 * ****************************************************************** */


$tbl_profile_videos = "SELECT * FROM tbl_profile_videos WHERE user_id='" . $_GET['id'] . "'";

$query_profile_videos = mysqli_query($link,$tbl_profile_videos);

if (mysqli_num_rows($query_profile_videos) > 0) {

    while ($profile_videos_row = mysqli_fetch_array($query_profile_videos)) {
        $tbl_products_videos = "SELECT * FROM tbl_products WHERE uid='" . $profile_videos_row['user_id'] . "' AND ref_id='" . $profile_videos_row['id'] . "' AND content_type='2'";

        $query_tbl_products_videos = mysqli_query($link,$tbl_products_videos);

        $tbl_products_row_videos = mysqli_fetch_array($query_tbl_products_videos);

        //echo $tbl_products_row_videos['id'];



        $music_video = "../_uploads/profile_product/" . $tbl_products_row_videos['id'] . ".jpg";
        if (file_exists($music_video)) {
            @unlink($music_video);
        }
        $music_video = "../_uploads/profile_product/thumb/" . $tbl_products_row_videos['id'] . ".jpg";
        if (file_exists($music_video)) {
            @unlink($music_video);
        }

        $video = "../_uploads/profile_video/" . $profile_videos_row['id'] . ".mp4";
        if (file_exists($video)) {
            @unlink($video);
        }

        $delete_tbl_products_videos = "DELETE FROM tbl_products WHERE id='" . $tbl_products_row_videos['id'] . "'";
        $delete_tbl_products_videos_row = mysqli_query($link,$delete_tbl_products_videos);

        $delete_tbl_profile_videos = "DELETE FROM tbl_profile_videos WHERE id='" . $profile_videos_row['id'] . "'";
        $query_tbl_profile_videos_row = mysqli_query($link,$delete_tbl_profile_videos);
    }
}

/* * *****************************************************************
  DELETE USER tbl_profile_events
 * ****************************************************************** */
$tbl_profile_events = "SELECT * FROM tbl_profile_events WHERE uid='" . $_GET['id'] . "'";

$query_profile_events = mysqli_query($link,$tbl_profile_events);

if (mysqli_num_rows($query_profile_events) > 0) {

    while ($profile_events_row = mysqli_fetch_array($query_profile_events)) {
        $profile_events = "../_uploads/profile_view_event_photo/" . $profile_events_row['id'] . ".jpg";
        if (file_exists($profile_events)) {
            @unlink($profile_events);
        }
        $profile_events = "../_uploads/profile_view_event_photo/thumb/" . $profile_events_row['id'] . ".jpg";
        if (file_exists($profile_events)) {
            @unlink($profile_events);
        }

        $delete_profile_events = "DELETE FROM tbl_profile_events WHERE id='" . $profile_events_row['id'] . "'";
        $delete_profile_events_row = mysqli_query($link,$delete_profile_events);
    }
}


/* * *****************************************************************
  DELETE USER tbl_profile_images
 * ****************************************************************** */
$tbl_profile_images = "SELECT * FROM tbl_profile_images WHERE userid='" . $_GET['id'] . "'";

$query_profile_images = mysqli_query($link,$tbl_profile_images);

if (mysqli_num_rows($query_profile_images) > 0) {

    while ($profile_images_row = mysqli_fetch_array($query_profile_images)) {
        $profile_images = "../_uploads/profile_images/" . $profile_images_row['id'] . ".jpg";
        
        @unlink("../_uploads/profile_images/12.jpg");
        if (file_exists($profile_images)) {
            
            @unlink($profile_images);
        }
        $profile_images = "../_uploads/profile_images/croped/" . $profile_images_row['id'] . ".jpg";
        if (file_exists($profile_images)) {
            @unlink($profile_images);
        }

        $delete_profile_images = "DELETE FROM tbl_profile_images WHERE id='" . $profile_images_row['id'] . "'";
        $delete_profile_images_row = mysqli_query($link,$delete_profile_images);
    }
}



/* * *****************************************************************
  DELETE USER book
 * ****************************************************************** */
$tbl_profile_books = "SELECT * FROM tbl_profile_books WHERE uid='" . $_GET['id'] . "'";

$query_profile_books = mysqli_query($link,$tbl_profile_books);

if (mysqli_num_rows($query_profile_books) > 0) {

    while ($profile_books_row = mysqli_fetch_array($query_profile_books)) {
        $tbl_products_books = "SELECT * FROM tbl_products WHERE uid='" . $profile_books_row['uid'] . "' AND ref_id='" . $profile_books_row['id'] . "' AND content_type='4'";

        $query_tbl_products_books = mysqli_query($link,$tbl_products_books);

        $tbl_products_row_books = mysqli_fetch_array($query_tbl_products_books);

        //echo $tbl_products_row_books['id'];

        $profile_books = "../_uploads/profile_product/" . $tbl_products_row_books['id'] . ".jpg";
        if (file_exists($profile_books)) {
            @unlink($profile_books);
        }
        $profile_books = "../_uploads/profile_product/thumb/" . $tbl_products_row_books['id'] . ".jpg";
        if (file_exists($profile_books)) {
            @unlink($profile_books);
        }

        $profile_books_image = "../_uploads/profile_book_photo/" . $profile_books_row['id'] . ".jpg";
        if (file_exists($profile_books_image)) {
            @unlink($profile_books_image);
        }
        $profile_books_image = "../_uploads/profile_book_photo/thumb/" . $profile_books_row['id'] . ".jpg";
        if (file_exists($profile_books_image)) {
            @unlink($profile_books_image);
        }

        $delete_tbl_products_products_books = "DELETE FROM tbl_products WHERE id='" . $tbl_products_row_books['id'] . "'";
        $delete_tbl_products_books_row = mysqli_query($link,$delete_tbl_products_products_books);

        $delete_products_books = "DELETE FROM tbl_profile_books WHERE id='" . $profile_books_row['id'] . "'";
        $delete_products_books_row = mysqli_query($link,$delete_products_books);
    }
}

/* * *****************************************************************
  DELETE USER Product
 * ****************************************************************** */

$tbl_products = "SELECT * FROM tbl_products WHERE uid='" . $_GET['id'] . "' AND content_type='0'";

$query_tbl_products = mysqli_query($link,$tbl_products);

if (mysqli_num_rows($query_tbl_products) > 0) {

    while ($tbl_products_row = mysqli_fetch_array($query_tbl_products)) {
        $img_products = "../_uploads/profile_product/" . $tbl_products_row['id'] . ".jpg";
        if (file_exists($img_products)) {
            @unlink($img_products);
        }
        $img_products = "../_uploads/profile_product/thumb/" . $tbl_products_row['id'] . ".jpg";
        if (file_exists($img_products)) {
            @unlink($img_products);
        }
        $delete_tbl_products = "DELETE FROM tbl_products WHERE id='" . $tbl_products_row['id'] . "'";
        $delete_tbl_products_row = mysqli_query($link,$delete_tbl_products);
    }
}

/* * *****************************************************************
  DELETE USER tbl_user_details
 * ****************************************************************** */

$delete_tbl_user_details = "DELETE FROM tbl_user_details WHERE user_id='" . $_GET['id'] . "'";
$query_delete_tbl_user_details = mysqli_query($link,$delete_tbl_user_details);


/* * *****************************************************************
  DELETE USER tbl_user_profile_settings
 * ****************************************************************** */

$delete_tbl_user_profile_settings = "DELETE FROM tbl_user_profile_settings WHERE uid='" . $_GET['id'] . "'";
$query_tbl_user_profile_settings = mysqli_query($link,$delete_tbl_user_profile_settings);

/* * *****************************************************************
  DELETE USER tbl_chat
 * ****************************************************************** */
$tbl_chat = "SELECT * FROM tbl_chat WHERE to_id='" . $_GET['id'] . "' OR from_id='" . $_GET['id'] . "'";

$query_tbl_chat = mysqli_query($link,$tbl_chat);

if (mysqli_num_rows($query_tbl_chat) > 0) {

    while ($tbl_chat_row = mysqli_fetch_array($query_tbl_chat)) {
        $delete_tbl_chat_row = "DELETE FROM tbl_chat WHERE id='" . $tbl_chat_row['id'] . "'";
        $delete_tbl_chat_query = mysqli_query($link,$delete_tbl_chat_row);
    }
}

/* * *****************************************************************
  DELETE USER tbl_profile_comments
 * ****************************************************************** */
$tbl_profile_comments = "SELECT * FROM tbl_profile_comments WHERE profile_id='" . $_GET['id'] . "' OR commenter_id='" . $_GET['id'] . "'";


$query_tbl_profile_comments = mysqli_query($link,$tbl_profile_comments);

if (mysqli_num_rows($query_tbl_profile_comments) > 0) {

    while ($tbl_profile_comments_row = mysqli_fetch_array($query_tbl_profile_comments)) {
        $delete_tbl_profile_comments_row = "DELETE FROM tbl_profile_comments WHERE id='" . $tbl_profile_comments_row['id'] . "'";
        $query_delete_tbl_profile_comments_row = mysqli_query($link,$delete_tbl_profile_comments_row);
    }
}

/* * *****************************************************************
  DELETE USER tbl_seller_bank
 * ****************************************************************** */
$delete_tbl_seller_bank = "DELETE FROM tbl_seller_bank WHERE uid='" . $_GET['id'] . "'";
$query_delete_tbl_seller_bank = mysqli_query($link,$delete_tbl_seller_bank);

/* * *****************************************************************
  DELETE USER tbl_user_activity
 * ****************************************************************** */
$delete_tbl_user_activity = "DELETE FROM tbl_user_activity WHERE user_id='" . $_GET['id'] . "'";
$query_delete_tbl_user_activity = mysqli_query($link,$delete_tbl_user_activity);

/* * *****************************************************************
  DELETE USER Account & user profile photo
 * ****************************************************************** */


$query = "DELETE FROM tbl_users WHERE id='" . $_GET['id'] . "'";

$query_row = mysqli_query($link,$query);
$img_location = "../_uploads/user_photo/" . $_GET['id'] . ".jpg";
if (file_exists($img_location)) {
    @unlink($img_location);
}



if($uid == 1 ){
    header('location: talent.php?op=del');
}
else{
    header('location: member.php?op=del');
}



?>	