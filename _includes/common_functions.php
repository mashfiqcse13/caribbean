<?php

/*
 * This will check if the admin is able to view the member area or talent area
 */

function Let_the_admin_see_the_user_dashboard() {
    if (empty($_SESSION['is_admin']) || strtolower($_SESSION['is_admin']) != "yes" || empty($_REQUEST['id']) || $_REQUEST['id'] < 1) {
        return FALSE;
    }
    $user_id = mysql_real_escape_string($_REQUEST['id']);
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
