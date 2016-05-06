<?php

/*
  Author	: MD. Mashfiqur Rahman
  website	: http://mashfiqnahid.com
  mail		: mashfiqnahid@gmail.com

  Intruduction	:
  =================
  This is used for profile picture manupulation .
 * 
 * Note : the 'class.database.php','Croper.php' library is required to be included . this library will need them .
 */

class Profile_pic {

    private $current_pic;
    private $necessary_script;
    private $user_id;
    private $user_type;
    private $error_msg = array();
    private $success_msg = array();
    private $errorStatus = 0;
    private $allowedFileExtentions = array(".jpg", ".jpeg", ".gif", ".png");
    private $root_path = '../';
    private $size_after_auto_resize = MEMBER_IMAGE_SIZE;
    private $auto_resize = true;
    private $destination_url_after_processing = 'update_profile_photo.php';
    private $db;

    function __construct($user_id, $user_type) {
        $this->user_id = $user_id;
        $this->user_type = $user_type;
        $this->db = new DBClass(db_host, db_username, db_passward, db_name);
    }

    function setRoot_path($root_path) {
        $this->root_path = $root_path;
    }

    function get_current_url() {
        return "Pro Pic";
    }

    function get_current_path() {
        return "Pro Pic";
    }

    /*
     * This method will return a array of image details . example :
     * $gallery_files = array(
     *      array(
     *          'file' => '...',
     *          'file_url' => '...',
     *          'imagename' => '...',
     *          'imagExtention' => '...',
     *          'photo_id' => '...'
     *          'status' => '...',
     *      ),
     *      array(
     *          'file' => '...',
     *          'file_url' => '...',
     *          'imagename' => '...',
     *          'imagExtention' => '...',
     *          'photo_id' => '...'
     *          'status' => '...',
     *      ),
     * )
     */

    function get_gallery($urls_only = FALSE) {
        $db = $this->db;
        $rows = $db->db_select_as_array('tbl_profile_images', " `userid` = " . $this->user_id);
        $gallery_files = array();
        $urls = array();
        foreach ($rows as $index => $row) {
            $imagename = $rows[$index]['imagename'];
            $imagExtention = explode('.', $imagename);
            $file['imagExtention'] = $imagExtention[1];

            if ($rows[$index]['status'] == 33) {
                $file['file'] = "../_uploads/croped/profile_images/croped/" . $imagename;
                $file['file_url'] = BASE_URL . "_uploads/profile_images/croped/" . $imagename;
            } else {
                $file['file'] = "../_uploads/profile_images/" . $imagename;
                $file['file_url'] = BASE_URL . "_uploads/profile_images/" . $imagename;
            }

            $file['photo_id'] = $rows[$index]['id'];
            $file['status'] = $rows[$index]['status'];
            $file['imagename'] = $imagename;
            array_push($gallery_files, $file);
            array_push($urls, $file['file_url']);
        }
        if ($urls_only) {
            return $urls;
        } else {
            return $gallery_files;
        }
    }

    function getError_msg() {
        return $this->error_msg;
    }

    function update($form_FILES_ARRAY, $go_to_cropping = FALSE) {
        /* move upload photo in temp folder */
        //get the file ext
        $filename = $form_FILES_ARRAY['name'];
        $file_ext = strrchr(preg_replace('/\.\w+$/e', 'strtolower("$0")', $filename), '.');

        //$file_ext = strrchr($filename, '.');
        //check if its allowed or not:
        $whitelist = $this->allowedFileExtentions;
        if (!in_array($file_ext, $whitelist)) {
            $this->go_to_destination('Not allowed extension,please upload images only!');
        } else {
            /* $linkcat=$this->root_path."_temp/".$this->user_id.'.jpg';
              @copy($_FILES["img_path"]["tmp_name"],$linkcat); */

            $source_path = $form_FILES_ARRAY['tmp_name'];
            $tmp_destination = $this->root_path . "_temp/" . $this->user_id . $file_ext;
            upload_my_file($source_path, $tmp_destination);



            /* create thumb upload photo in user_photo folder taking pic from temp folder */
            $source = $tmp_destination;
            $destination = $this->root_path . "_uploads/user_photo/" . $this->user_id . $file_ext;

            $this->change_from_exsiting($source, $destination);


            $db = $this->db;
            $next_id = $db->auto_increment_id('tbl_profile_images');

            $imagename = $next_id . $file_ext;
            $successflag = 0;
            $src = $tmp_destination;
            $des = $this->root_path . "_uploads/profile_images/" . $this->user_id . $file_ext;
            $newdes = $this->root_path . "_uploads/profile_images/" . $imagename;
            //deleting if destination is there

            copy($src, $des);
            rename($des, $newdes);

            $data_to_insert = array(
                'userid' => $this->user_id,
                'imagename' => $imagename,
                'status' => 1,
                'createddate' => 'now()'
            );

            if ($db->db_insert('tbl_profile_images', $data_to_insert)) {
                $successflag = 1;
            } else {
                array_push($this->success_msg, 'Database Failed');
            }

            /* delete temp folder photo */
            if (file_exists($tmp_destination)) {
                unlink($tmp_destination);
            }
            if ($successflag == 0) {
                echo "something happened seriously";
                die;
            }


            array_push($this->success_msg, 'Your Profile Photo has been updated Successfully!');

            if ($go_to_cropping == 1) {
                $this->destination_url_after_processing = "media_img_cropper.php?photoid=" . $db->last_insert_id('tbl_profile_images');
            }
            $this->go_to_destination();
        }
    }

    function change_from_exsiting($source, $destination) {
        // if previous user profile pic found
        $this->delete($destination);

        if ($this->auto_resize) {
            create_thumb($source, $this->size_after_auto_resize, $destination);
        } else {
            copy($source, $destination);
        }


//            if (file_exists($destination)) {
//                die("$destination fount");
//            } else {
//                die("$destination not fount");
//            }

        /* Adding Activity log */
        $uname = (GetChatUserName($this->user_id));
        SaveActivity(1, $uname, '', $this->user_id);
    }

    function select_from_gallery($photo_id) {
        extract($this->get_file_by($photo_id));
        if ($status == 33) {
            $file = str_replace('profile_images/', 'profile_images/croped/', $file);
        }
        $destination = "../_uploads/user_photo/" . $this->user_id . ".jpg";
        $this->change_from_exsiting($file, $destination);

        $this->go_to_destination();
    }

    // it will delet the profile photo .and go to the destination page, if you don't give the target
    function delete($target = FALSE) {
        if (!$target) {
            $target = "../_uploads/user_photo/" . $this->user_id . ".jpg";
        }
        $this->delete_file_by($target);

        if (!$target) {
            $this->go_to_destination();
        }
    }

    function delete_file_by($target_path) {
        if (file_exists($target_path)) {
            unlink($target_path);
        }
    }

    function delete_by($photoid) {
        $file = $this->get_file_by($photoid);
//        die(print_r($file));
        $target = $file['file'];
        $croped_target = str_replace('profile_images/', 'profile_images/croped/', $target);

        $this->db->db_delete('tbl_profile_images', " `id` = " . $photoid);

        $this->delete_file_by($target);
        $this->delete_file_by($croped_target);

        $this->go_to_destination();
    }

    function go_to_destination($msg = FALSE) {
        if ($msg) {
            die('
                <script>
                        alert("' . $msg . '");
                        window.location = "' . $this->destination_url_after_processing . '";
                </script>
                ');
        } else {
            die('
                <script>
                        window.location = "' . $this->destination_url_after_processing . '";
                </script>
                ');
        }
    }

    function update_photo_status_by($photo_id, $status_code) {
        $data_to_insert = array(
            'status' => $status_code,
        );
        $condition = '`id` = ' . $photo_id;
        $table_name = 'tbl_profile_images';
        $this->db->db_update($table_name, $data_to_insert, $condition);
    }

    /*
     * Getting file details . Return example
     * $file = array(
     *          'file' => '...',
     *          'file_url' => '...',
     *          'imagename' => '...',
     *          'status' => '...'
     *      )
     */

    function get_file_by($photo_id) {
        $db = $this->db;
        $result = $db->db_select_as_array('tbl_profile_images', "`id` = $photo_id AND  `userid` = " . $this->user_id);
        $imagename = $result[0]['imagename'];
        $imagExtention = explode('.', $imagename);
        $file['imagExtention'] = $imagExtention[1];

        $file['file'] = "../_uploads/profile_images/" . $imagename;
        $file['file_url'] = BASE_URL . "_uploads/profile_images/" . $imagename;
        $file['imagename'] = $imagename;
        $file['status'] = $result[0]['status'];

        return $file;
    }

    function crop($photo_id, $cropping_data, $back_2_destinaion = TRUE) {
        $src_file_detail = $this->get_file_by($photo_id);
        $src_path = $src_file_detail['file'];
        $destinaion = str_replace('profile_images/', 'profile_images/croped/', $src_path);

        $this->delete_file_by($destinaion);

        $cropper = new Croper();
        $cropper->resize_existing($src_path, $cropping_data, $destinaion);

        //setting image status to 33 means it is croped
        $this->update_photo_status_by($photo_id, 33);

        if ($back_2_destinaion) {
            $this->go_to_destination();
        } else {
            return true;
        }
    }

    function uncrop($photo_id) {
        $src_file_detail = $this->get_file_by($photo_id);
        $src_path = $src_file_detail['file'];
        $croped_file = str_replace('profile_images/', 'profile_images/croped/', $src_path);

        $this->delete_file_by($croped_file);

        //setting image status to 33 means it is croped
        $this->update_photo_status_by($photo_id, 1);

        $this->go_to_destination();
    }

}
