<?php

include('../_includes/application-top.php');
ChecknontalentLogin();
//print_r($_SESSION);
//http://caribbeancirclestars.com/member/add_product_to_favorite.php?item_id=23&item_type=video

$item_id = $_GET['item_id'];
$item_type = $_GET['item_type'];

if (!empty($item_id)) {
    $user_id = $_SESSION['user_id'];
    $db = new DBClass(db_host, db_username, db_passward, db_name);

    if (!empty($item_type) && $item_type == "photo") {
        $data_to_insert = array(
            'id_user' => $user_id,
            'id_photo' => $item_id
        );
        $db->db_insert('tbl_user_fav_photo', $data_to_insert);
    } else if (!empty($item_type) && $item_type == "music") {
        $data_to_insert = array(
            'id_user' => $user_id,
            'id_music' => $item_id
        );
        $db->db_insert('tbl_user_fav_music', $data_to_insert);
    } else if (!empty($item_type) && $item_type == "video") {
        $data_to_insert = array(
            'id_user' => $user_id,
            'id_video' => $item_id
        );
        $db->db_insert('tbl_user_fav_video', $data_to_insert);
    }
}
?>
<script type="text/javascript">
    window.history.back();
</script>

