<?php

/**
 * This will take care of media files
 *
 * @author MD. Mashfiq
 */
class media {

    private $db;

    function __construct() {
        $this->db = new DBClass(db_host, db_username, db_passward, db_name);
    }

    /*
     * This will get all media as array . some selection code are :
     * 
     * 1. pic_music_vedio => to select only pic, video,music
     */

    function get_all_media_as_array($selection_code = 'pic_music_vedio') {
        $table_name = 'tbl_contact';
        $condition = "`type_of_file` IN ('Photo','Video','Music')";
        return $this->db->db_select_as_array($table_name, $condition);
    }

}
