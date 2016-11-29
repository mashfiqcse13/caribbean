<?php

/*
 * This will check if the admin is able to view the member area or talent area
 */

function Let_the_admin_see_the_user_dashboard() {
    global $link;
    if (empty($_SESSION['is_admin']) || strtolower($_SESSION['is_admin']) != "yes" || empty($_REQUEST['id']) || $_REQUEST['id'] < 1) {
        return FALSE;
    }
    $user_id = mysqli_real_escape_string($link, $_REQUEST['id']);
    $db = new DBClass(db_host, db_username, db_passward, db_name);
    $result = $db->db_select_as_array('tbl_users', "id = '$user_id'");
    if (empty($result[0])) {
        return FALSE;
    }
    $user_details = $result[0];
    if ($user_details['type'] == 0) {
        $_SESSION['user_id'] = $user_id;
    } else if ($user_details['type'] == 1) {
        $_SESSION['talent_id'] = $user_id;
    } else {
        return FALSE;
    }
    return $user_id;
}

function is_favorite($item_id, $item_type) {
    $user_id = $_SESSION['user_id'];

    if ($item_type == "photo") {
        $table_name = 'tbl_user_fav_photo';
        $colum_name = 'id_photo';
    } else if ($item_type == "music") {
        $table_name = 'tbl_user_fav_music';
        $colum_name = 'id_music';
    } else if ($item_type == "video") {
        $table_name = 'tbl_user_fav_video';
        $colum_name = 'id_video';
    }
    $db = new DBClass(db_host, db_username, db_passward, db_name);
    $result = $db->db_select_as_array($table_name, " `id_user` =$user_id AND `$colum_name` =$item_id");
    if ($result == FALSE) {
        return false;
    } else {
        return TRUE;
    }
}
