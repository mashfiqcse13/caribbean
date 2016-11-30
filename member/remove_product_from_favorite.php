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
        $db->db_delete('tbl_user_fav_photo', "`id_user` = $user_id and `id_photo` = $item_id  ");
    } else if (!empty($item_type) && $item_type == "music") {
        $db->db_delete('tbl_user_fav_music', "`id_user` = $user_id and `id_music` = $item_id  ");
    } else if (!empty($item_type) && $item_type == "video") {
        $db->db_delete('tbl_user_fav_video', "`id_user` = $user_id and `id_video` = $item_id  ");
    }
}
?>
<script type="text/javascript">
    window.history.back();
</script>

