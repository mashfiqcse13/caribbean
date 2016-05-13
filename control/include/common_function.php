<?php

//
//it will show the media item
//
function show_media($media_id) {
    $db = new DBClass(db_host, db_username, db_passward, db_name);
    $table_name = 'tbl_contact';
    $condition = "`id` =$media_id";
    $result = $db->db_select_as_array($table_name, $condition);
//    return print_r($result, TRUE);
    $result = $result[0];
    $output = "<div style=\"text-align: center;\">\n";
    if ($result['type_of_file'] == 'Photo') {
        $output .= '<img height="300" src="' . BASE_URL . $result['file_attached'] . '" />';
    } else if ($result['type_of_file'] == 'Music') {
        $output .= '<audio  width="400" id="player" src="' . BASE_URL . $result['file_attached'] . '" type="audio/mp3" controls="controls"></audio>';
    } else if ($result['type_of_file'] == 'Video') {
        $output .= '<video width="500" height="300" controls>
                                <source src="' . BASE_URL . $result['file_attached'] . '" type="video/mp4">
                                Your browser does not support the video tag.
                            </video> ';
    }
    $output .= "</div>\n";
    return $output;
}
