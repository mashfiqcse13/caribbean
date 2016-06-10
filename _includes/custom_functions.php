<?php

/* Login check for talent */

function ChecktalentLogin() {
    if (isset($_SESSION['talent_login']) AND ( $_SESSION['talent_login'] == 1)) { // logged in
        //echo $_SESSION['talent_login'];
    } else {
        header('location:login.php?op=invalid');
        //echo $_SESSION['talent_login'];
    }
}

/* LOGIN CHECK NONTALENT */

function ChecknontalentLogin() {
    if (isset($_SESSION['user_login']) AND ( $_SESSION['user_login'] == 1)) {
        
    } else {
        header('location:login.php?op=invalid');
    }
}

/* all LOGIN CHECK FORE FORUM */

function CheckLoginALL() {
    if ((isset($_SESSION['user_login']) AND ( $_SESSION['user_login'] == 1)) || (isset($_SESSION['talent_login']) AND ( $_SESSION['talent_login'] == 1)) || (isset($_SESSION['cms_login']) && ($_SESSION['cms_login'] != 0))) {
        
    } else {
        ?>
        <script type="text/javascript">window.location = "http://www.caribbeancirclestars.com/member/login.php";</script>

        <?php

    }
}

/* LOGIN CHECK NONTALENT FORE FORUM */

function CheckLoginForum() {
    if ((isset($_SESSION['user_login']) AND ( $_SESSION['user_login'] == 1)) || (isset($_SESSION['talent_login']) AND ( $_SESSION['talent_login'] == 1))) {
        
    } else {
        header('location:member/login.php');
    }
}

function GetPageText($page_name) {
    $sql = "select  cms_text from   tbl_cms where name='" . $page_name . "' AND status=1";
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);
    echo str_replace("admin@caribbeancirclestars.com", "<a href='mailto:admin@caribbeancirclestars.com'>admin@caribbeancirclestars.com</a>", $row["cms_text"]);
}

function GetPageHeading($page_name) {
    $sql = "select  heading from   tbl_cms where name='" . $page_name . "' AND status=1";
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);
    echo $row["heading"];
}

/* 	function GetMetaTitle($page_name)
  {
  $sql = "select  page_title from   tbl_cms where name='".$page_name."'";
  $query=mysql_query($sql);
  $row=mysql_fetch_assoc($query);
  echo $row["page_title"];
  } */

function GetMetaKeyword($page_name) {
    $sql = "select  meta_keyword from tbl_cms where name='" . $page_name . "'";
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);
    echo $row["meta_keyword"];
}

/* TALENTS-AND-NONTALENTS */
/* 	function CheckProfileView($TNname){


  } */

/* TALENTS-PART */

function CheckProfileView($ername) {
//			$sql="SELECT ud.user_id AS UID, ud.profile_display_status, u.id,u.type " .
//		     "FROM tbl_user_details AS ud " .
//				 "LEFT OUTER JOIN tbl_users AS u " .
//				 "ON u.id=ud.user_id " .
//				 "WHERE u.username='" . $ername . "'AND type='1' ";
//
//
//		$result1=mysql_query($sql) or die(mysql_error());
//
//		$data1=mysql_fetch_array($result1);
//
//		//get profile status
//
//		if($data1['profile_display_status']!=0){
//			return 1;
//		}
//		else
//		{
//			//check if user is not logged in
//			if($data1['UID']==$_SESSION['talent_id']){
//			 return 1;
//			}else{
//				//rerdirect to login page
//		   header('location: talents/login.php');
//			}
//		}
}

////////////////////////////////////////////////////////////////////////
//////// for chat username
function GetChatUserName($id) {
    $sql = "SELECT username FROM tbl_users WHERE id='" . $id . "'";
    $query = mysql_query($sql);
    $row = mysql_fetch_array($query);
    return $row["username"];
}

////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////
//////// GetUserName


function GetFullName($username) {
    $sql = "SELECT   tbl_users.first_name,tbl_users.last_name FROM   tbl_users WHERE username='" . $username . "'";
    $query = mysql_query($sql);
    $row = mysql_fetch_assoc($query);
    $name = $row["first_name"] . " " . $row["last_name"];
    return $name;
}

///////////////////////////////////ONLINE ACTIVITY ////////////////////////////////////////
function Onlineactivity() {

    if ((isset($_SESSION["talent_id"])) && ($_SESSION["talent_id"] != 0) AND ( $_SESSION['is_admin'] != "yes")) {
        $uid = $_SESSION["talent_id"];
    } elseif ((isset($_SESSION["user_id"])) && ($_SESSION["user_id"] != 0) AND ( @$_SESSION['is_admin'] != "yes")) {
        $uid = $_SESSION["user_id"];
    } else {
        //
    }


    /* ###################GET VALUE FROM tbl_user_online############### */
    if (isset($uid)) {
        $SQL_QUERY = "SELECT * FROM tbl_user_online WHERE uid='" . $uid . "'";
        $SQL_RESULT = mysql_query($SQL_QUERY);
        $SQL_fetch = mysql_fetch_assoc($SQL_RESULT);
        $SQL_ROWS = mysql_num_rows($SQL_RESULT);
        if ($SQL_ROWS == '') {
            /* ###################INSERT VALUE FROM tbl_user_online############### */
            $data = array(
                "uid" => $uid,
                "last_activity" => date('Y-m-d H:i:s')
            );
            $table = "tbl_user_online";
            insertData($data, $table);
        } else {

            /* ###################UPDATE VALUE FROM tbl_user_online############### */
            $data = array(
                "last_activity" => date('Y-m-d H:i:s')
            );

            $table = "tbl_user_online";
            $parameters = "uid='" . $uid . "'";
            updateData($data, $table, $parameters);
        }
        //echo $SQL_fetch['last_activity'];
        $value = $SQL_fetch['last_activity'];
        //echo 'data_time='.$value;
        //echo '<br>';
        //echo 'current_time='.$current_time=date('Y-m-d h:i:s');
    }

    //////////////////////////////////////////////////////////////////////////
    /* ###################DELETE VALUE FROM tbl_user_online BEFORE 5 MINUTES############### */
    $before_5_min = (date('Y-m-d H:i:s', strtotime('-5 minutes')));
    //echo $before_5_min;
    $sql = "DELETE FROM tbl_user_online WHERE last_activity<'" . $before_5_min . "'";
    mysql_query($sql);
    ////////////////////////////////////////////////////////////////////////////
}

/////////////////////////////////////////////////////////////
//	Name: This function reads the extension of the file.
//	Date: 27-05-2011
/////////////////////////////////////////////////////////////
function getExtension($str) {
    $i = strrpos($str, ".");
    if (!$i) {
        return "";
    }
    $l = strlen($str) - $i;
    $ext = substr($str, $i + 1, $l);
    return $ext;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
// Name: Upload Thumb Image
// Date: 16-01-2012
/////////////////////////////////////////////////////////////
function create_image_thumb($source, $destination, $size) {
    $source_size = getimagesize($source);
    $width = $source_size[0];
    $height = $source_size[1];
    $source_ratio = $width / $height;
    $new_ratio = $size / $size;

    if ($source_ratio > $new_ratio) {
        $newwidth = $size;
        $newheight = (int) ($size / $source_ratio);
    } else {
        $newwidth = (int) ($size * $source_ratio);
        $newheight = $size;
    }

    $new_image = imagecreatetruecolor($newwidth, $newheight) or die('Cannot Initialize new GD image stream');

    $extension = getExtension($source);

    if ($extension == 'jpg' || $extension == 'jpeg')
        $image = imagecreatefromjpeg($source);

    if ($extension == 'gif')
        $image = imagecreatefromgif($source);

    if ($extension == 'png')
        $image = imagecreatefrompng($source);

    imagecopyresampled($new_image, $image, 0, 0, $x, $y, $newwidth, $newheight, $width, $height);


//imagecopyresampled(

    if ($extension == 'jpg' || $extension == 'jpeg')
        imagejpeg($new_image, $destination);

    if ($extension == 'gif')
        imagegif($new_image, $destination);

    if ($extension == 'png')
        imagepng($new_image, $destination);
}

///////////////////////////////////////////////////////////////////////////////////////////////////
///////////////////////////////////////////////// Activity Log //////////////////////////////////////////////////
function SaveActivity($text, $uname, $p_name, $uid) {

    if ($text == 1) {
        $activity = $uname . " " . AC1 . " " . $p_name;
    } elseif ($text == 2) {
        $activity = $uname . " " . AC2 . " " . $p_name;
    } elseif ($text == 3) {
        $activity = $uname . " " . AC3 . " " . $p_name;
    } elseif ($text == 4) {
        $activity = $uname . " " . AC4 . " " . $p_name;
    } elseif ($text == 5) {
        $activity = $uname . " " . AC5 . " " . $p_name;
    } elseif ($text == 6) {
        $activity = $uname . " " . AC6 . " " . $p_name;
    } elseif ($text == 7) {
        $activity = $uname . " " . AC7 . " " . $p_name;
    } elseif ($text == 8) {
        $activity = $uname . " " . AC8 . " " . $p_name;
    } elseif ($text == 9) {
        $activity = $uname . " " . AC9 . " " . $p_name . " " . " Profile ";
    } elseif ($text == 10) {
        $activity = $uname . " " . AC10 . " " . $p_name;
    } elseif ($text == 11) {
        $activity = $uname . " " . AC11 . " " . $p_name;
    } elseif ($text == 12) {
        $activity = $uname . " " . AC12 . " " . $p_name;
    } elseif ($text == 13) {
        $activity = $uname . " " . AC13 . " " . $p_name;
    } else {
        $activity = $uname . " " . AC14 . " " . $p_name;
    }

    $data = array(
        "user_id" => $uid,
        "activity" => $activity
    );
    $table = "tbl_user_activity";
    insertData($data, $table);
}

///////////////////////////////////////////////////////////////////////////////////////////////////

function age_from_dob($dob) {

    list($d, $m, $y) = explode('-', $dob);

    if (($m = (date('m') - $m)) < 0) {
        $y++;
    } elseif ($m == 0 && date('d') - $d < 0) {
        $y++;
    }

    return date('Y') - $y;
}