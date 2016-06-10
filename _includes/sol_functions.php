<?php

//	Author: Solutiononline.co.in
//Last Updated 23-Aug-2012
/////////////////////////////////////////////////////////////
//	Name: Email Send Function (SMTP + mail)
//	Date: 23-08-2012
/////////////////////////////////////////////////////////////
function SendEMail($to, $subject, $msg, $from) {
    $opt = 1;

    //function spamcheck($field)
//	{
//	//filter_var() sanitizes the e-mail
//	//address using FILTER_SANITIZE_EMAIL
//	$field=filter_var($field, FILTER_SANITIZE_EMAIL);
//	
//	//filter_var() validates the e-mail
//	//address using FILTER_VALIDATE_EMAIL
//	if(filter_var($field, FILTER_VALIDATE_EMAIL))
//		{
//		return TRUE;
//		}
//	else
//		{
//		return FALSE;
//		}
//	}
// validating input for blank entry
//if(!isset(trim($from))) { return false; }
//if(!isset(trim($to))) { return false; }
//if(!isset(trim($subject))) { return false; }
//if(!isset(trim($msg))) { return false; }
//check if the email address is invalid
//$mailcheck = spamcheck($from); if ($mailcheck==FALSE) { return false; }
//$mailcheck = spamcheck($to); if ($mailcheck==FALSE) { return false; }

    if (!defined('PHP_EOL'))
        define('PHP_EOL', strtoupper(substr(PHP_OS, 0, 3) == 'WIN') ? "\r\n" : "\n");


    if ($opt == 1) { //Mail function
        // HTML email BOF
        $headers = "From: " . trim($from) . PHP_EOL;
        $headers .= "Reply-To: " . trim($from) . PHP_EOL;
        $headers .= "Message-ID: <" . time() . "SolFunction@" . $_SERVER['SERVER_NAME'] . ">" . PHP_EOL;
        $headers .= 'X-Sender-IP: ' . $_SERVER["REMOTE_ADDR"] . PHP_EOL;
        $headers .= "X-Mailer: PHP v" . phpversion() . PHP_EOL;
        $headers .= 'MIME-Version: 1.0' . PHP_EOL;
        $headers .= 'Content-type: text/html; charset=iso-8859-1' . PHP_EOL;
        $headers .= "X-Priority: 1" . PHP_EOL;

        $to = trim($to);
        $message = trim($msg);
        $subject = trim($subject);
        return mail($to, $subject, $message, $headers);
        //HTML email EOF
    } else { //SMTP
        //////SMTP Mail BOF //////		
        //if pear is installed on server, this will work(tested)
        require_once("Mail.php");
        require_once("Mail/mime.php");

        $headers = array(
            'From' => $from, //$from should only be the email for smtp like a@a.com
            'Return-Path' => $from, //$from should only be the email for smtp like a@a.com
            'To' => $to,
            'Subject' => $subject);

        // SMTP params
        $smtp_params["host"] = "mail.solutiononline.org"; //setup SMTP host
        $smtp_params["port"] = "25"; //post is optional if ssl is not used reguller 25, ssl 465
        $smtp_params["username"] = "test@solutiononline.org"; //setup SMTP username
        $smtp_params["password"] = "solution2004"; //setup SMTP password
        // Creating the Mime message
        $mime = new Mail_mime("\n");

        // Setting the body of the email
        $mime->setTXTBody(strip_tags($msg));
        $mime->setHTMLBody($msg);

        $body = $mime->get();
        $headers = $mime->headers($headers);

        // Sending the email using smtp
        $mail = & Mail::factory("smtp", $smtp_params);
        $result = $mail->send($to, $headers, $body);
        //$mail = $smtp->send($to, $headers, $body); //sending the mail
//if($result === 1)
//        {
//          echo("Your message has been sent!");
//        }
//        else
//        {
//          echo("Your message was not sent: " . $result);
//        }		
        if ($result === 1) {
            return true;
        } else {
            return false;
        }
        /////// SMTP mail EOF
    }
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Downloading the file from particular location
//	Date: 11-02-2010
// 	Instructions: Pass path and file name
/////////////////////////////////////////////////////////////
function download_file($file_path, $file_name) {
    $filename = $file_path . $file_name;
    header("Cache-control: private");
    header("Content-Type: application/octet-stream");
    header("Content-Length: " . filesize($filename));
    header("Content-Disposition: attachment; filename=\"" . $file_name . "\"");

    $fp = fopen($filename, 'r');
    fpassthru($fp);
    fclose($fp);
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Random Password Generator
//	Date: 24-02-2009
// 	Instructions: Pass password leath and get a random password
/////////////////////////////////////////////////////////////
function random_password($length) {
    $rstr = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $nstr = "";
    mt_srand((double) microtime() * 1000000);
    while (strlen($nstr) < $length) {
        $random = mt_rand(0, (strlen($rstr) - 1));
        $nstr .= $rstr{$random};
    }
    //echo "Pass ->".$nstr;	die;
    return($nstr);
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Remove quoted from a string
//	Date: 24-02-2009
// 	Instructions: Pass string with quotes to get string without quotes
/////////////////////////////////////////////////////////////
function removeQuotes($strToChange) {
    $strToChange = str_replace("'", "&#39;", $strToChange);
    $strToChange = str_replace("\"", "&quot;", $strToChange);
//	$strToChange=str_replace("\\","&#92;",$strToChange);
    return $strToChange;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to insert data in any table.
//	Date: 03-03-2009
// 	Instructions: Pass the table name, and arry of filedname and value in function.
//	USE---
//	$data=array("name"=>"Pratik Dutta","address"=>"Burdwan","company"=>"SolutionOnline");
//	$insert=InsertData($data,$tablename);
/////////////////////////////////////////////////////////////
function insertData($data, $table) {

    if (!empty($data)) {
        $fld_names = implode(', ', array_keys($data));
        $fld_values = '\'' . implode('\', \'', array_values($data)) . '\'';
        $sql = 'INSERT INTO ' . $table . ' (' . $fld_names . ') VALUES (' . $fld_values . ')';

        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    }
    return 0;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to edit data from any table
//	Date: 03-03-2009
// 	Instructions: Pass the table name, and arry of filedname and value in function.
//	USE---
//	$data=array("name"=>"Pratik Dutta","address"=>"Burdwan","company"=>"SolutionOnline");
//	$update=updateDB($data,$tablename, " name = 'Pratik'");
/////////////////////////////////////////////////////////////
function updateData($data, $table, $parameters = '') {

    if ($parameters != '') {
        $where = "WHERE " . $parameters;
    } else {
        $where = '';
    }

    if (!empty($data)) {
        $fld_names = array_keys($data);
        $fld_values = array_values($data);
        $data = 'SET ';
        for ($max = count($fld_names), $i = 0; $i < $max; $i++) {
            $data .= $fld_names[$i] . ' = \'' . $fld_values[$i] . '\' ';
            if ($i < $max - 1)
                $data .= ', ';
        }
        $sql = 'UPDATE ' . $table . ' ' . $data . ' ' . $where;

        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    }
    return 0;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to delete data in any table.
// 	Instructions: Pass the table name, and condition in function.
//	USE---
//	$delete=deletedata($data,$tablename);
/////////////////////////////////////////////////////////////
function deletedata($table, $parameters = '') {

    if ($parameters != '') {
        $where = "WHERE " . $parameters;
    } else {
        $where = '';
    }

    if (!empty($table)) {
        $sql = 'DELETE FROM ' . $table . ' ' . $where;
        $result = mysql_query($sql) or die(mysql_error());
        return $result;
    }
    return 0;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to get one record from anytable($table) having wny where clase($whereClause)
//	Date: 24-02-2009
// 	Instructions: Pass the table name and where clause like " and id=1"
/////////////////////////////////////////////////////////////
function getAnyTableWhereData($table, $whereClause) {
    //echo "<br> $table,$whereClause";	
    $query = "select * from $table where 1=1 $whereClause ";
    //echo "<br>$query";
    $result = mysql_query($query) or die(mysql_error());

    if ($row = mysql_fetch_array($result)) {
        mysql_free_result($result);
        return $row;
    } else {
        return false;
    }
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to check image size
//	Date: 24-02-2009
// 	Instructions: Pass the image url to check the size
/////////////////////////////////////////////////////////////
function CheckImageSize($imageUrl) {
//echo $imageUrl;
    $imMaxWidth = $GLOBALS["imMaxWidth"];
    $imMaxHeight = $GLOBALS["imMaxHeight"];
    $img_dim = array();
    if (($imageUrl != DIR_WS_IMAGES) && (file_exists($imageUrl))) {
        if ($imDetail = getimagesize($imageUrl)) {
            $iWidth = $imDetail[0];
            $iHeight = $imDetail[1];
            $toWidth = $iWidth;
            $toHeight = $iHeight;
            //		echo $iWidth." ".$iHeight." ".$imMaxWidth;
            if (($iWidth >= $iHeight) && ($iWidth > $imMaxWidth)) {
                $newWidth = $imMaxWidth;
                $reduce_per = ($imMaxWidth / $iWidth) * 100;
                $newHeight = ($iHeight * $reduce_per) / 100;
                //			echo "here";
            } else if (($iWidth < $iHeight) && ($iHeight > $imMaxHeight)) {
                $newHeight = $imMaxHeight;
                $reduce_per = ($imMaxHeight / $iHeight) * 100;
                $newWidth = ($iWidth * $reduce_per) / 100;
                //			echo $newHeight." dd ".$newWidth;
            } else {
                $newHeight = $iHeight;
                $newWidth = $iWidth;
            }
            $img_dim['width'] = round($newWidth);
            $img_dim['height'] = round($newHeight);
        } else {
            $img_dim['width'] = "";
            $img_dim['height'] = "";
        }
        $idimension = " width = '$img_dim[width]' height='$img_dim[height]'";
        //	print_r($img_dim);
        //	return $idimension;
    }
    //return $img_dim;
    return $idimension;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to Upload file
//	Date: 08-06-2010
// 	Instructions: 
/////////////////////////////////////////////////////////////
function upload_my_file($upload_file, $destination) {
    //chmod($destination,"0777");	//allow write permission	
//	//Sanitize the filename (See note below)
//	$remove_these = array(' ','`','"','\'','\\','/');
//	$newname = str_replace($remove_these,'',$_FILES['image']['name']);
    //move_uploaded_file
    if (move_uploaded_file($upload_file, $destination)) {
        return true;
    } else {
        return false;
    }
    umask("0000");
    chmod($destination, "0755"); //disable write permission
}

///////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
// Functions for image
// Date: 24-02-2009
// Instructions: create_thumb($dest,$thumb_size,$dest_thumb);
// pass the size as 100, its for the ration of the new image
/////////////////////////////////////////////////////////////
function create_thumb($path, $size, $save_path) {
//echo "sdsd";
//echo $path;
    if (file_exists($path)) {

//if(strstr(strtolower($path),".gif")!="")
//{
//}
//else
//{

        $thumb = new my_thumbnail($path); // generate image_file, set filename to resize
        $thumb->size_width(500); // set width for thumbnail, or
        $thumb->size_height(500); // set height for thumbnail, or

        $width = $thumb->img["lebar"];
        $height = $thumb->img["tinggi"];
        if ($width > $size || $height > $size) {
            $size = $size;
        } else {
            $size = $width;
        }

        $thumb->size_auto($size); // set the biggest width or height for thumbnail
        $thumb->jpeg_quality(100); // [OPTIONAL] set quality for jpeg only (0 - 100) (worst - best), default = 75
// $thumb->show(); // show your thumbnail
        $thumb->save($save_path); // save your thumbnail to file
// echo "saved";
// }
    } else {
        return false;
    }
}

/* ---------------------------------------------- */

class my_thumbnail {

    var $img;

    function my_thumbnail($imgfile) {
//
// //detect image format
// $this->img["format"]=ereg_replace(".*\.(.*)$","\\1",$imgfile);
// $this->img["format"]=strtoupper($this->img["format"]);
////// applying my image format detect
        list($width, $height, $type, $att) = getimagesize($imgfile);
        if ($type == 1) {
            $this->img["format"] = "GIF";
        } elseif ($type == 2) {
            $this->img["format"] = "JPG";
        } elseif ($type == 3) {
            $this->img["format"] = "PNG";
        }
///////

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
//JPEG
            $this->img["format"] = "JPEG";
            $this->img["src"] = ImageCreateFromJPEG($imgfile);
        } elseif ($this->img["format"] == "PNG") {
//PNG
            $this->img["format"] = "PNG";
            $this->img["src"] = ImageCreateFromPNG($imgfile);
        } elseif ($this->img["format"] == "GIF") {
//GIF
            $this->img["format"] = "GIF";
            $this->img["src"] = ImageCreateFromGIF($imgfile);
        } elseif ($this->img["format"] == "WBMP") {
//WBMP
            $this->img["format"] = "WBMP";
            $this->img["src"] = ImageCreateFromWBMP($imgfile);
        } else {
//DEFAULT
            echo "Not Supported File";
            exit();
        }

        @$this->img["lebar"] = imagesx($this->img["src"]);
        @$this->img["tinggi"] = imagesy($this->img["src"]);

//default quality jpeg
        $this->img["quality"] = 100;
    }

    function size_height($size = 100) {
//height
        $this->img["tinggi_thumb"] = $size;

        @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
    }

    function size_width($size = 100) {
//width
        $this->img["lebar_thumb"] = $size;
        @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
    }

    function size_auto($size = 100) {
//size
        if ($this->img["lebar"] >= $this->img["tinggi"]) {
            $this->img["lebar_thumb"] = $size;
            @$this->img["tinggi_thumb"] = ($this->img["lebar_thumb"] / $this->img["lebar"]) * $this->img["tinggi"];
        } else {
            $this->img["tinggi_thumb"] = $size;
            @$this->img["lebar_thumb"] = ($this->img["tinggi_thumb"] / $this->img["tinggi"]) * $this->img["lebar"];
        }
    }

    function jpeg_quality($quality) {
//jpeg quality
        $this->img["quality"] = $quality;
    }

    function show() {
//show thumb
        @Header("Content-Type: image/" . $this->img["format"]);

        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);
        imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
//JPEG
            imageJPEG($this->img["des"], "", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {
//PNG
            imagePNG($this->img["des"]);
        } elseif ($this->img["format"] == "GIF") {
//GIF
            imageGIF($this->img["des"]);
        } elseif ($this->img["format"] == "WBMP") {
//WBMP
            imageWBMP($this->img["des"]);
        }
    }

    function save($save = "") {
//save thumb
        if (empty($save))
            $save = strtolower("./thumb." . $this->img["format"]);
        /* change ImageCreateTrueColor to ImageCreate if your GD not supported ImageCreateTrueColor function */
        $this->img["des"] = ImageCreateTrueColor($this->img["lebar_thumb"], $this->img["tinggi_thumb"]);
        @imagecopyresampled($this->img["des"], $this->img["src"], 0, 0, 0, 0, $this->img["lebar_thumb"], $this->img["tinggi_thumb"], $this->img["lebar"], $this->img["tinggi"]);

        if ($this->img["format"] == "JPG" || $this->img["format"] == "JPEG") {
//JPEG
            imageJPEG($this->img["des"], "$save", $this->img["quality"]);
        } elseif ($this->img["format"] == "PNG") {
//PNG
            imagePNG($this->img["des"], "$save");
        } elseif ($this->img["format"] == "GIF") {
//GIF
            imageGIF($this->img["des"], "$save");
        } elseif ($this->img["format"] == "WBMP") {
//WBMP
            imageWBMP($this->img["des"], "$save");
        }
    }

}

////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to get age from date
//	Date: 24-02-2009
// 	Instructions: just pass the date of birth in function
/////////////////////////////////////////////////////////////
function GetAge($DOB) {
    list($Year, $Month, $Day) = explode("-", $DOB);
    $YearDifference = date("Y") - $Year;
    $MonthDifference = date("m") - $Month;
    $DayDifference = date("d") - $Day;
    if ($DayDifference < 0 || $MonthDifference < 0) {
        $YearDifference--;
    }
    return $YearDifference;
}

/////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to compare the difference in two dates and return days
//	Date: 24-02-2009
// 	Instructions: 
/////////////////////////////////////////////////////////////
function date_diff_two_date($start, $end) {
    $start = substr($start, 0, 10);
    $start = str_replace("-", "", $start);

    $end = substr($end, 0, 10);

    $end = str_replace("-", "", $end);

    $count = 0;
    for ($j = $start; $j <= $end; $j++) {
        $year = substr($j, 0, 4);
        $mnd = substr($j, 4, 2);
        $day = substr($j, 6, 2);
        if (checkdate($mnd, $day, $year)) {
            $count++;
        } else {
            if ($mnd > 12) {
                $mnd = "01";
                $day = "00";
                $year++;
            }

            if ($day >= 31) {
                $day = "00";
                $mnd = check($mnd + 1);
            }
            $j = $year . $mnd . $day;
        }
    }

    return $count;
}

///related function
function check($x) {
    return (strlen($x) == 1 ? "0" . $x : $x);
}

///////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to return the no of days in month start
//	Date: 24-02-2009
// 	Instructions: 
/////////////////////////////////////////////////////////////
function daysInMonth($month, $year) {
    if (checkdate($month, 31, $year))
        return 31;
    if (checkdate($month, 30, $year))
        return 30;
    if (checkdate($month, 29, $year))
        return 29;
    if (checkdate($month, 28, $year))
        return 28;
    return 0; // error
}

function date_timelisting($date, $seldd = "day", $selmm = "month", $selyy = "year", $hr = "hour", $min = "minutes", $sec = "sec", $startYear = "", $endYear = "") {
    if ($date != "") {
        list($year, $month, $day) = split("-", $date);
        $str_date = explode(" ", $date);
        list($hrs, $mins, $secs) = split(":", $str_date[1]);
    }
    //print_r($str_date); 
    //echo $hrs;
    //date dropdown
    print '<select name="' . $seldd . '"><option value="">Date</option>';
    $ct = 0;
    for ($ct = 1; $ct <= 31; $ct++) {
        echo "<option value='" . ($ct) . "'";
        if ($ct == $day) {
            echo " selected";
        }
        echo ">" . $ct . "</option>";
    }
    print "</select>";
    print" - ";

    //month dropdown
    print '<select name="' . $selmm . '"><option value="">Month</option>';
    $ct = 0;
    for ($ct = 0; $ct < 12; $ct++) {
        echo "<option value='" . ($ct + 1) . "'";

        if (($ct + 1) == $month) {
            echo " selected";
        }
        echo ">" . date("M", mktime(0, 0, 0, $ct + 1, 1, 98)) . "</option>";
    }
    print'</select>';
    print" - ";
    //Year dropdown

    print '<select name="' . $selyy . '"><option value="">Year</option>';
    $ct = 0;
    if ($startYear == "") {
        $s_yy = (date('Y') - 1);
    } else {
        $s_yy = $startYear;
    }

    if ($endYear == "") {
        $e_yy = (date('Y') + 1);
    } else {
        $e_yy = $endYear;
    }

    for ($ct = $s_yy; $ct <= $e_yy; $ct++) {
        echo "<option value='" . ($ct) . "'";
        if ($ct == $year) {
            echo " selected";
        }
        echo ">" . $ct . "</option>";
    }
    print "</select>";
    print " - ";
    //Hour dropdown
    print '<select name="' . $hr . '"><option value="">Hour</option>';
    for ($ct = 0; $ct <= 23; $ct++) {
        echo "<option value='" . ($ct) . "'";
        if (($ct) == $hrs && $hrs != "") {
            echo " selected";
        }
        echo ">" . $ct . "</option>";
    }
    print "</select>";
    print " - ";
    //Minute dropdown
    print '<select name="' . $min . '"><option value="">Minutes</option>';
    for ($ct = 0; $ct <= 59; $ct++) {
        echo "<option value='" . ($ct) . "'";
        if (($ct) == $mins && $mins != "") {
            echo " selected";
        }
        echo ">" . $ct . "</option>";
    }
    print "</select>";
    print " - ";
    //Second dropdown
    print '<select name="' . $sec . '"><option value="">Second</option>';
    for ($ct = 0; $ct <= 59; $ct++) {
        echo "<option value='" . ($ct) . "'";
        if (($ct) == $mins && $mins != "") {
            echo " selected";
        }
        echo ">" . $ct . "</option>";
    }
    print "</select>";
}

////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to return the file name from where request originated start
//	Date: 24-02-2009
// 	Instructions: 
/////////////////////////////////////////////////////////////
function GetRedirectUrl() {

    $REDIRECT_URL = $_SERVER['HTTP_REFERER']; // redirecting URL

    $full_url = $REDIRECT_URL; // complete redirecting url  
    $all_url = explode("/", $full_url); // explode url   
    $all_url = array_reverse($all_url); // reverse array to fetch file name
    $return_url = $all_url[0]; // return file name

    $pos = strpos($return_url, "?"); // find position of ? in url
    if ($pos) {
        $return_url = substr($return_url, 0, $pos);
    }

    return $return_url;
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////
//	Function to Send SMS Message
//	Date: 01-03-2009
// 	Instructions: Send Mobile No and Message to the function, mobile no with out + and 00 in begining with country code
//	Clicktell API is used to send messages http://www.clickatell.com
/////////////////////////////////////////////////////////////
function SendSMS($Destination, $Message) {

    $user = "unitedglobal";  //username
    $password = "funfid6k"; //password
    $api_id = "3113631"; //API
    $baseurl = "http://api.clickatell.com";
    $text = urlencode($Message);
    $to = $Destination; //example 919932130035 (country code is 91 and rest is the number)
    // auth call
    $url = "$baseurl/http/auth?user=$user&password=$password&api_id=$api_id";
    // do auth call
    $ret = file($url);
    // split our response. return string is on first line of the data returned
    $sess = split(":", $ret[0]);
    if ($sess[0] == "OK") {
        $sess_id = trim($sess[1]); // remove any whitespace
        $url = "$baseurl/http/sendmsg?session_id=$sess_id&to=$to&text=$text";
        // do sendmsg call
        $ret = file($url);
        $send = split(":", $ret[0]);
        if ($send[0] == "ID")
        //echo "success message ID: ". $send[1];
            return TRUE;
        else
            return FALSE;
        //echo "send message failed";
    } else {
        echo "Authentication failure: " . $ret[0];
        return FALSE;
    }
}

/////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////
// Parse the data used in the html tags to ensure the tags will not break
function tep_parse_input_field_data($data, $parse) {
    return strtr(trim($data), $parse);
}

function tep_not_null($value) {
    if (is_array($value)) {
        if (sizeof($value) > 0) {
            return true;
        } else {
            return false;
        }
    } else {
        if (($value != '') && (strtolower($value) != 'null') && (strlen(trim($value)) > 0)) {
            return true;
        } else {
            return false;
        }
    }
}

function tep_output_string($string, $translate = false, $protected = false) {
    if ($protected == true) {
        return htmlspecialchars($string);
    } else {
        if ($translate == false) {
            return tep_parse_input_field_data($string, array('"' => '&quot;'));
        } else {
            return tep_parse_input_field_data($string, $translate);
        }
    }
}

/////////////////////////////////////////////////////////////
//	Function to Create Anchor Link
//	Date: 09-03-2009
// 	Instructions: 
//	call link: echo "<a href="' . tep_href_link(FILENAME_DEFAULT) . '">Click Here</a>";
//	echo '<a href="' . tep_href_link('page1.php','id=1&a=2') . '">Click Here</a>'; // with paramiter
/////////////////////////////////////////////////////////////
function tep_href_link($page = '', $parameters = '') {

    if (!tep_not_null($page)) {
        die('<font color="#ff0000"><b>Error!</b></font><br><br><b>Unable to determine the page link!<br><br>');
    }

    if (tep_not_null($parameters)) {
        $link .= $page . '?' . tep_output_string($parameters);
        $separator = '&';
    } else {
        $link .= $page;
        $separator = '?';
    }

    while ((substr($link, -1) == '&') || (substr($link, -1) == '?'))
        $link = substr($link, 0, -1);

//    if ( (SEARCH_ENGINE_FRIENDLY_URLS == 'true') && ($search_engine_safe == true) ) {
//      while (strstr($link, '&&')) $link = str_replace('&&', '&', $link);
//
//      $link = str_replace('?', '/', $link);
//      $link = str_replace('&', '/', $link);
//      $link = str_replace('=', '/', $link);
//
//      $separator = '?';
//    }

    return $link;
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	The HTML image display function
//	Date: 09-03-2009
// 	Instructions: 
//	echo tep_image('Critical_Thinking.jpg','Alter Text Here',200,200);
/////////////////////////////////////////////////////////////////////
function tep_image($src, $alt = '', $width = '', $height = '', $parameters = '', $stretch = 'false') {
    if ((empty($src) || ($src == DIR_WS_IMAGES)) && (IMAGE_REQUIRED == 'false')) {
        return false;
    }
// alt is added to the img tag even if it is null to prevent browsers from outputting
// the image filename as default
    $image = '<img src="' . tep_output_string($src) . '" border="0" alt="' . tep_output_string($alt) . '"';

    if (tep_not_null($alt)) {
        $image .= ' title=" ' . tep_output_string($alt) . ' "';
    }

//	if ( (CONFIG_CALCULATE_IMAGE_SIZE == 'true') )
//		{
    if ($image_size = @getimagesize($src)) {
        if (empty($width) && tep_not_null($height)) {
            if (($image_size[1] < $height) && ($stretch == 'false')) {
                // EC - if width hasn't been passed in, the image height is smaller than the setting, and stretch is false, use original dimensions
                $width = $image_size[0];
                $height = $image_size[1];
            } else {
                // EC - if width hasn't been passed, and the image height is larger than the setting, height ends up as the setting and width is modified to suit
                $ratio = $height / $image_size[1];
                $width = $image_size[0] * $ratio;
            }
        } elseif (tep_not_null($width) && empty($height)) {
            // EC - if height hasn't been passed in, the image width is smaller than the setting, and stretch is false, use original dimensions
            if (($image_size[0] < $width) && ($stretch == 'false')) {
                $width = $image_size[0];
                $height = $image_size[1];
            } else {
                // EC - if height hasn't been passed, and the image width is larger than the setting, width ends up as the setting and height is modified to suit
                $ratio = $width / $image_size[0];
                $height = $image_size[1] * $ratio;
            }
        } elseif (empty($width) && empty($height)) {
            // EC - if neither height nor width are passed in, just use the original dimensions
            $width = $image_size[0];
            $height = $image_size[1];
        }
        //EC - added the following elseif for calculating based on stretch/no-stretch
        elseif (tep_not_null($width) && tep_not_null($height)) {
            if ((($image_size[0] > $width) || ($image_size[1] > $height)) && ($stretch == 'false')) {
                // EC - if width and height are both passed in, either original height or width are larger than the setting, and stretch is false, resize both dimensions to suit
                $new_ratio = $height / $width;
                $image_ratio = $image_size[1] / $image_size[0];
                if ($new_ratio >= $image_ratio) {
                    $height = $image_size[1] * ($width / $image_size[0]);
                } else {
                    $width = $image_size[0] * ($height / $image_size[1]);
                }
            } elseif ($stretch == 'false') {
                // EC - if we got here, both width and height have been passed in, both original height and width are smaller than setting, and stretch is set to false. So just use original dimensions.
                $width = $image_size[0];
                $height = $image_size[1];
            }
        }
    } elseif (IMAGE_REQUIRED == 'false') {
        return false;
    }
//		}

    if (tep_not_null($width) && tep_not_null($height)) {
        $image .= ' width="' . tep_output_string($width) . '" height="' . tep_output_string($height) . '"';
    }

    if (tep_not_null($parameters))
        $image .= ' ' . $parameters;

    $image .= '>';

    return $image;
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	Email Validate Function
//	Date: 06-04-2009
// 	Instructions: 
//	pass email addredd to the function, and get true or flase as return
/////////////////////////////////////////////////////////////////////
function isValidEmail($email) {
    return eregi("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$", $email);
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	Image Create Function
//	Date: 09-06-2010
// 	Instructions: 
//	pass required height, width and the final image will be resized and cropped to fit that size without distortion
/////////////////////////////////////////////////////////////////////
function CreateFixedSizedImage($source, $dest, $width = 100, $height = 100) {

    $source_path = $source;

    list( $source_width, $source_height, $source_type ) = getimagesize($source_path);

    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($source_path);
            break;

        case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($source_path);
            break;

        case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($source_path);
            break;
    }

    $source_aspect_ratio = $source_width / $source_height;
    $desired_aspect_ratio = $width / $height;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        //
        // Triggered when source image is wider
        //
    $temp_height = $height;
        $temp_width = (int) ( $height * $source_aspect_ratio );
    } else {
        //
        // Triggered otherwise (i.e. source image is similar or taller)
        //
    $temp_width = $width;
        $temp_height = (int) ( $width / $source_aspect_ratio );
    }

    //
    // Resize the image into a temporary GD image
    //

  $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
            $temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
    );

    //
    // Copy cropped region from temporary image into the desired GD image
    //

  $x0 = ( $temp_width - $width ) / 2;
    $y0 = ( $temp_height - $height ) / 2;
    $y0 = 0; //from top

    $desired_gdim = imagecreatetruecolor($width, $height);
    imagecopy(
            $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $width, $height
    );

    //
    // Render the image
    // Alternatively, you can save the image in file-system or database
    //

  //header( 'Content-type: image/jpeg' );
    imagejpeg($desired_gdim, $dest);

    //
    // Add clean-up code here
//
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	Image Display Function
//	Date: 09-06-2010
// 	Instructions: 
//	pass required height, width and the final image will be resized and cropped to fit that size without distortion
/////////////////////////////////////////////////////////////////////
function ShowFixedSizedImage($source, $width = 100, $height = 100) {

    $source_path = $source;

    list( $source_width, $source_height, $source_type ) = getimagesize($source_path);

    switch ($source_type) {
        case IMAGETYPE_GIF:
            $source_gdim = imagecreatefromgif($source_path);
            break;

        case IMAGETYPE_JPEG:
            $source_gdim = imagecreatefromjpeg($source_path);
            break;

        case IMAGETYPE_PNG:
            $source_gdim = imagecreatefrompng($source_path);
            break;
    }

    $source_aspect_ratio = $source_width / $source_height;
    $desired_aspect_ratio = $width / $height;

    if ($source_aspect_ratio > $desired_aspect_ratio) {
        //
        // Triggered when source image is wider
        //
    $temp_height = $height;
        $temp_width = (int) ( $height * $source_aspect_ratio );
    } else {
        //
        // Triggered otherwise (i.e. source image is similar or taller)
        //
    $temp_width = $width;
        $temp_height = (int) ( $width / $source_aspect_ratio );
    }

    //
    // Resize the image into a temporary GD image
    //

  $temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
    imagecopyresampled(
            $temp_gdim, $source_gdim, 0, 0, 0, 0, $temp_width, $temp_height, $source_width, $source_height
    );

    //
    // Copy cropped region from temporary image into the desired GD image
    //

  $x0 = ( $temp_width - $width ) / 2;
    $y0 = ( $temp_height - $height ) / 2;

    $desired_gdim = imagecreatetruecolor($width, $height);
    imagecopy(
            $desired_gdim, $temp_gdim, 0, 0, $x0, $y0, $width, $height
    );

    //
    // Render the image
    // Alternatively, you can save the image in file-system or database
    //

  header('Content-type: image/jpeg');
    imagejpeg($desired_gdim);

    //
    // Add clean-up code here
//
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	Image ExportToExcel
//	Date: 23-04-2011
// 	Instructions: Pass query, file name and heading(optional) like below
//  ExportToExcel($query,"excelfile.xls","Records Heading");
/////////////////////////////////////////////////////////////////////
function ExportToExcel($query, $excel_file_name, $heading = '') {

    $tmprst = mysql_query($query);
    $num_field = mysql_num_fields($tmprst);

    if ($heading <> "") {
        $body = $heading . "\t \n ";
    }
    while ($fld = mysql_fetch_field($tmprst)) {
        $body.="" . $fld->name . "\t";
    }
    $body.="\n";

    while ($row = mysql_fetch_array($tmprst)) {
        $body.="";
        for ($i = 0; $i < $num_field; $i++) {
            $body.="" . $row[$i] . "\t";
        }
        $body.="\n";
    }

    header("Content-type: application/octet-stream"); //A MIME attachment with the content type "application/octet-stream" is a binary file.
    //Typically, it will be an application or a document that must be opened in an application, such as a spreadsheet or word processor. 
    header("Content-Disposition: attachment; filename=$excel_file_name"); //with this extension of file name you tell what kind of file it is.
    header("Pragma: no-cache"); //Prevent Caching
    header("Expires: 0"); //Expires and 0 mean that the browser will not cache the page on your hard drive
    echo $body;
}

/////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////
//	Get Current Browser URL
//	Date: 15-09-2011
// 	Just call this to get the current browser url
/////////////////////////////////////////////////////////////////////
function selfURL() {

    function strleft($s1, $s2) {
        return substr($s1, 0, strpos($s1, $s2));
    }

    if (!isset($_SERVER['REQUEST_URI'])) {
        $serverrequri = $_SERVER['PHP_SELF'];
    } else {
        $serverrequri = $_SERVER['REQUEST_URI'];
    } $s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
    $protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/") . $s;
    $port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":" . $_SERVER["SERVER_PORT"]);
    return $protocol . "://" . $_SERVER['SERVER_NAME'] . $port . $serverrequri;
}

/////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Convert IP Address into Country Code
// Date: 12-04-2012
// pass the ip address in the function
//////////////////////////////////////////////////////////////////////////////////////
function ip2country($ip) {
    $country = file_get_contents('http://api.hostip.info/country.php?ip=' . $ip);
    return $country;
}

////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Converting numbers to words
// Date: 23-08-2012
// pass the number in the function
//////////////////////////////////////////////////////////////////////////////////////
function numberToWords($number) {
    $words = array(
        0 => 'Zero',
        1 => 'One',
        2 => 'Two',
        3 => 'Three',
        4 => 'Four',
        5 => 'Five',
        6 => 'Six',
        7 => 'Seven',
        8 => 'Eight',
        9 => 'Nine',
        10 => 'Ten',
        11 => 'Eleven',
        12 => 'Twelve',
        13 => 'Thirteen',
        14 => 'Fourteen',
        15 => 'Fifteen',
        16 => 'Sixteen',
        17 => 'Seventeen',
        18 => 'Eighteen',
        19 => 'Nineteen',
        20 => 'Twenty',
        30 => 'Thirty',
        40 => 'Fourty',
        50 => 'Fifty',
        60 => 'Sixty',
        70 => 'Seventy',
        80 => 'Eighty',
        90 => 'Ninety',
        100 => 'Hundred',
        1000 => 'Thousand',
        100000 => 'Lakh',
        10000000 => 'Crore');

    if (is_numeric($number)) {
        $number = (int) round($number);

        if ($number < 0) {
            $number = -$number;
            $number_in_words = 'minus ';
        }

        if (array_key_exists($number, $words)) {
            if ($number > 90) {
                $one = "one ";
            }
            $number_in_words = $number_in_words . " " . $one . $words[$number];
        } else {
            if ($number > 10000000) {
                $number_in_words = $number_in_words . numberToWords(floor($number / 10000000)) . " " . $words[10000000];
                $lakhs = $number % 10000000;
                $thusends = $number % 100000;
                $hundreds = $number % 1000;
                $tens = $hundreds % 100;
                if ($lakhs > 100000) {
                    $number_in_words = $number_in_words . ", " . numberToWords($lakhs);
                }
                if ($thusends > 1000) {
                    $number_in_words = $number_in_words . ", " . numberToWords($thusends);
                } else if ($hundreds > 100) {
                    $number_in_words = $number_in_words . ", " . numberToWords($hundreds);
                } elseif ($tens) {
                    $number_in_words = $number_in_words . " and " . numberToWords($tens);
                }
            } elseif ($number > 100000) {
                $number_in_words = $number_in_words . numberToWords(floor($number / 100000)) . " " . $words[100000];
                $thusends = $number % 100000;
                $hundreds = $number % 1000;
                $tens = $hundreds % 100;
                if ($thusends > 1000) {
                    $number_in_words = $number_in_words . ", " . numberToWords($thusends);
                } else if ($hundreds > 100) {
                    $number_in_words = $number_in_words . ", " . numberToWords($hundreds);
                } elseif ($tens) {
                    $number_in_words = $number_in_words . " and " . numberToWords($tens);
                }
            } else if ($number > 1000) {
                $number_in_words = $number_in_words . numberToWords(floor($number / 1000)) . " " . $words[1000];
                $hundreds = $number % 1000;
                $tens = $hundreds % 100;

                if ($hundreds == 100) {
                    $number_in_words = $number_in_words . ",  " . numberToWords(100);
                } elseif ($hundreds > 100) {
                    $number_in_words = $number_in_words . ", " . numberToWords($hundreds);
                } elseif ($tens) {
                    $number_in_words = $number_in_words . " and " . numberToWords($tens);
                }
            } elseif ($number > 100) {
                $number_in_words = $number_in_words . numberToWords(floor($number / 100)) . " " . $words[100];
                $tens = $number % 100;
                // echo $tens;
                if ($tens) {
                    $number_in_words = $number_in_words . " and " . numberToWords($tens);
                }
            } elseif ($number > 20) {
                $number_in_words = $number_in_words . " " . $words[10 * floor($number / 10)];
                $units = $number % 10;
                if ($units) {
                    $number_in_words = $number_in_words . numberToWords($units);
                }
            }
        }
    } else {
        //$number_in_words="Please Enter any number";
        $number_in_words = "";
    }

    return $number_in_words;
}

/////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////
// Function to create safe alise for url
// Date: 23-08-2012
// pass string to get alise
//////////////////////////////////////////////////////////////////////////////////////
function CreateAlise($name) {

    $name = strtolower(trim($name));

    $name = str_replace("_", "-", $name);
    $name = str_replace("+", "-", $name);

    $name = str_replace("~", "", $name);
    $name = str_replace("!", "", $name);
    $name = str_replace("@", "", $name);
    $name = str_replace("#", "", $name);
    $name = str_replace("$", "", $name);
    $name = str_replace("%", "", $name);
    $name = str_replace("^", "", $name);
    $name = str_replace("&amp;", "", $name);
    $name = str_replace("&", "n", $name);
    $name = str_replace("*", "", $name);
    $name = str_replace("(", "", $name);
    $name = str_replace(")", "", $name);
    $name = str_replace("=", "", $name);
    $name = str_replace("{", "", $name);
    $name = str_replace("}", "", $name);
    $name = str_replace("[", "", $name);
    $name = str_replace("]", "", $name);
    $name = str_replace("'", "", $name);
    $name = str_replace("|", "", $name);
    $name = str_replace(":", "", $name);
    $name = str_replace(";", "", $name);
    $name = str_replace("<", "", $name);
    $name = str_replace(">", "", $name);
    $name = str_replace(",", "", $name);
    $name = str_replace(".", "", $name);
    $name = str_replace("?", "", $name);
    $name = str_replace("\"", "-", $name);
    $name = str_replace("/", "-", $name);
    $name = str_replace("\\", "-", $name);
//	$name = ereg_replace("[^ -A-Za-z]", "", $name);
//	$name = str_replace("1","",$name);
//	$name = str_replace("2","",$name);	
//	$name = str_replace("3","",$name);
//	$name = str_replace("4","",$name);
//	$name = str_replace("5","",$name);
//	$name = str_replace("6","",$name);
//	$name = str_replace("7","",$name);	
//	$name = str_replace("8","",$name);
//	$name = str_replace("9","",$name);
//	$name = str_replace("0","",$name);

    $name = str_replace(" ", "-", $name);  //preg_replace($pattern, $replacement, $string);
    $name = str_replace("--", "-", $name);
    $name = str_replace("--", "-", $name);
    $name = str_replace("--", "-", $name);
    $name = str_replace("--", "-", $name);

    $first = substr($name, 0, 1);

    if ($first == "-") {
        $name = substr($name, 1);
    }

    if (strlen($name) > 50) {
        $name = substr($name, 0, 50);
    }

    $alise = $name;

    return $alise;
}
