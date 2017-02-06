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

function show_music($music_id) {
    $src = BASE_URL . "_uploads/profile_music/" . $music_id . ".mp3";
    $output = '<audio controls>
        <source src="' . $src . '" type="audio/ogg">
      Your browser does not support the audio element.
      </audio>';
    return $output;
}

function show_video($video_type, $video_id) {

    if ($video_type == 1) {     // means it is a file type
        $src = BASE_URL . '_uploads/profile_video/' . $video_id . '.mp4';
        $output = '<video  width="315" height="220" controls>
                    <source src="' . $src . '" type="video/mp4">
                    <source src="movie.ogg" type="video/ogg">
                  Your browser does not support the video tag.
                  </video>';
    } else if (!empty($video_id)) {        // there is a video code
        global $connt, $selt;
        $result = mysqli_query($link, "SELECT * FROM  tbl_profile_videos WHERE id='" . $video_id . "' ");
        $data = mysqli_fetch_assoc($result);
        //print_r($data);
        $output = preg_replace('/width=("|\')(\d+|\d+px|)("|\')/i', 'width="315"', $data['video_code']);
        $output = preg_replace('/height=("|\')(\d+|\d+px|)("|\')/i', 'height="220"', $output);
    }
    return $output;
}

function is_favorite($item_id, $item_type) {
    if (empty($_SESSION['user_id'])) {
        return FALSE;
    }

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
