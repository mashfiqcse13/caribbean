<?php
//date_default_timezone_set('America/Los_Angeles');
include('_includes/application-top.php');
//session_start();
//require_once('contact.php');
/* ini_set('display_errors',1);
  $from = "prabumhn8@yahoo.com"; // sender
  $subject = "This is yth rtr";
  $message = "this i s rgrg ";
  // message lines should not exceed 70 characters (PHP rule), so wrap it
  $message = wordwrap($message, 70);
  // send mail
  echo mail("prabumhn8@gmail.com",$subject,$message,"From: $from\n"); */
//   echo "Thank you for sending us feedback";
//set_time_limit(0);
ini_set('max_execution_time', 1000);
ini_set('post_max_size', '1024M');
ini_set('upload_max_filesize', '1024M');
//error_reporting(E_ALL); // or E_STRICT
//ini_set("display_errors",1);
ini_set("memory_limit", "1024M");

// phpinfo();
?>

<?php
if ((isset($_POST['submit'])) && ($_POST['submit'] == "Submit")) {

    if (empty($_SESSION['security_code1']) || strcasecmp($_SESSION['security_code1'], $_POST['letters_code']) != 0) {
        extract($_POST);
        $errmsg = "The security code does not match!";
    } else {

        extract($_POST);


        $to = "admin@caribbeancirclestars.com";
        // $to = "prabumhn8@gmail.com";
        // Allowed file types. add file extensions WITHOUT the dot.
        $allowtypes = array("zip", "rar", "doc", "pdf", "docx", "ppt", "pptx", "jpg", "jpeg", "gif", "mp3", "mp4", "wma");

        // Require a file to be attached: false = Do not allow attachments true = allow only 1 file to be attached
        $requirefile = "true";

        // Maximum file size for attachments in KB NOT Bytes for simplicity. MAKE SURE your php.ini can handel it,
        // post_max_size, upload_max_filesize, file_uploads, max_execution_time!
        // 2048kb = 2MB,       1024kb = 1MB,     512kb = 1/2MB etc..
        $max_file_size = "5048000";
        /* $max_file_size="1024"; */

        // Thank you message
        $thanksmessage = "Your email has been sent, we will respond shortly.";

        $errors = array(); //Initialize error array
        //checks for a name
        if (empty($name)) {
            $errors[] = 'You forgot to enter your name';
        }


        //checks attachment file
        // checks that we have a file
        if ((!empty($_FILES["attachment"])) && ($_FILES['attachment']['error'] == 0)) {
            // basename -- Returns filename component of path
            $filename = basename($_FILES['attachment']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            $filesize = $_FILES['attachment']['size'];
            $max_bytes = $max_file_size * 1024;

            if ($filesize > $max_bytes) {
                $errors[] = "Your file: <strong>" . $filename . "</strong> is to big. Max file size is " . $max_file_size . "kb.";
            }
        } // if !empty FILES

        if (empty($errors)) { //If everything is OK
            // send an email
            // Obtain file upload vars
            $fileatt = $_FILES['attachment']['tmp_name'];
            $fileatt_type = $_FILES['attachment']['type'];
            $fileatt_name = $_FILES['attachment']['name'];


            if (!filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Invalid Email";
            }
            if (empty($_POST['name'])) {
                $nameErr = "Name is required";
            } else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST['name'])) {
                    $nameErr = "Only letters and white space allowed";
                }
            }
            if (empty($_POST['company'])) {
                $companyErr = "Company is required";
            } else {
                // check if name only contains letters and whitespace
                if (!preg_match("/^[a-zA-Z ]*$/", $_POST['company'])) {
                    $companyErr = "Only letters and white space allowed";
                }
            }

            if (empty($emailErr) && empty($nameErr) && empty($companyErr)) {

                $info = pathinfo($_FILES['attachment']['name']);
                $ext = $info['extension']; // get the extension of the file
                $newname = "newname" . date('Y-m-d-H-i-s') . "." . $ext;
                $target = 'uploadcontact/' . $newname;
                if (!empty($_FILES['attachment']['name'])) {
                    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $target)) {
                        // echo "jjjj";
                    } else {
                        //echo "iiii";
                    }
                } else {
                    $target = "";
                }

                $Query = "INSERT INTO `tbl_contact`
                                    (`name`,
                                     `email`,
                                     `company`,
                                     `job_title`,
                                     `query_subject`,
                                     `query`,
                                     `file_attached`,
                                     `join_date`,
                                     `join_time`)
                        VALUES ('" . $name . "',
                                '" . $email . "',
                                '" . $company . "',
                                '" . $job_title . "',
                                '" . $query_sub . "',
                                '" . $query . "',
                                '" . $target . "',
                                '" . date("Y-m-d") . "',
                                '" . (date("h:i:s A")) . "');";

                mysql_query($Query);

                //echo $message;
                //exit();
                //   if(!mail($to,$subject,$message,$headers)) {
                //   exit("Mail could not be sent. Sorry! An error has occurred, please report this to the website administrator.\n");
                // } else {
                ///mail("fahad_qurashi_123@yahoo.com",$subject,$message,$headers);
                //mail("prabumhn8@yahoo.com",$subject,$message,$headers);
                //echo "Success!";
                //mail($sendCc,$subject,$message,$headers);
                //echo '<div id="formfeedback"><h3>Thank You!</h3><p>'. $thanksmessage .'</p></div>';
                //  } // end of if !mail


                require_once('_includes/class.phpmailer.php');
                // send mail function
                $smtp_host = "smtp.caribbeancirclestars.com";
                $smtp_port = "25";
                $smtp_user = "adminccs@caribbeancirclestars.com";
                $smtp_pass = "fQe@49vi=,IT";
                $smtp_secure = "ssl";
                $reply_to = $email;
                $to_email = "admin@caribbeancirclestars.com";
                //$to_email  = "prabumhn8@gmail.com";
                $to_name = $name;
                $from_email = $email;
                $from_name = $name . " " . $company;
                $subject = "Contact Submision";
                //$body= "0ontat sdfsf";

                $body = "<br /><br />Dear Admin,<br /><br />
		          		Below Details are submitted by " . $name . "<br /><br />
									Name : " . $name . "<br />
									Email : " . $email . "<br />
									Company : " . $company . "<br />
									Job title : " . $job_title . "<br />
									Query Subject : " . $query_sub . "<br />
									Query : " . $query . "<br />";
                $contents.="Sincerely,<br />
                The " . SITE_NAME . " Team" . "<br />";

                //global $error,$smtp_host,$smtp_port,$smtp_user,$smtp_pass,$smtp_secure,$from_email,$reply_to,$from_name;
                $mail = new PHPMailer();  // create a new object
                $mail->IsSMTP(); // enable SMTP
                $mail->SMTPDebug = 1;  // debugging: 1 = errors and messages, 2 = messages only
                $mail->SMTPAuth = true;  // authentication enabled
                //$mail->SMTPSecure = $smtp_secure; // secure transfer enabled REQUIRED for Gmail tls/ssl
                $mail->Host = $smtp_host;
                $mail->Port = $smtp_port;
                $mail->Username = $smtp_user;
                $mail->Password = $smtp_pass;
                $mail->SetFrom($from_email, $from_name);
                $mail->AddReplyTo($reply_to);
                $mail->Subject = $subject;
                $mail->Body = $body;
                $mail->AddAddress($to_email);
                $mail->AddAttachment($target, $newname);
                $mail->IsHTML(true); // send as HTML
                //echo "tsr";
                if (!$mail->Send()) {
                    echo $error = 'Mail error:$smtp_host ' . $mail->ErrorInfo;
                } else {

                    echo $error = 'Message sent!';
                }


                header("Location: contact_success.php");
            }
        } else { //report the errors
            echo '<div id="formfeedback"><h3>Error!</h3><p>The following error(s) has occurred:<br />';
            foreach ($errors as $msg) { //prints each error
                echo " - $msg<br />\n";
            } // end of foreach
            echo '</p><p>Please try again</p></div>';
            //print_form();
        } //end of if(empty($errors))
    }
}
?>
<?php include('_includes/header.php'); ?>

<script type="text/ecmascript">
    window.onbeforeunload = function() {
    return "This action is not valid";
    };

    function new_captcha()
    {
    var c_currentTime = new Date();
    var c_miliseconds = c_currentTime.getTime();
    document.getElementById('captcha').src = '_includes/image.php?x='+ c_miliseconds;
    }

    $(document).ready(function(){
    $('#donate_form').validate()
    });



</script>
<style type="text/css">
    <!--
    #error-box{
        position:static;
        width:auto;
        padding:3px;
        font-family:Arial, Helvetica, sans-serif;
        font-weight:normal;
        font-size:12px;
        color:#CC0000;
    }

    .errortext{
        font-family:Arial, Helvetica, sans-serif;
        font-size:12px;
        color:#FF0000;
        font-weight:normal;
    }
    -->
</style>


<div class="content">
    <?php
    if (isset($msg) AND ( $msg != "")) {
        ?>
        <p class="msg"><?php echo $msg; ?></p><br />
    <?php } ?>
    <!--<h1>CONTACT</h1>-->
    <h1><?php echo GetPageHeading('Contact'); ?></h1>
    <p><?php echo GetPageText('Contact'); ?></p>
    <div class="form_class"><!--START CLASS form_class PART -->

        <?php /* ?> <p>
          If you need to send any material like music, photos, videos etc please email them to <span style="font-weight:bold;">
          <a href="mailto: <?php echo TO_ADMIN;?>" target="_blank"><?php echo TO_ADMIN;?></a></span>
          </p><?php */ ?>


        <p>Please fill the form below to reach us.</p>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="donate_form" id="donate_form" enctype="multipart/form-data">
            <?php
            if ((isset($errmsg)) && ($errmsg != "")) {
                echo "<p align='center'><span id='error-box'><font class='errortext'>" . $errmsg . "</font></span></p>";
            }
            ?>
            <?php
            if ((isset($thanksmessage)) && ($thanksmessage != "") && empty($emailErr) && empty($nameErr) && empty($companyErr)) {
                echo '<div id="formfeedback"><p class="msg">' . $thanksmessage . '</p></div>';
            }
            ?>
            <p>
                <label for="">Name:</label>
                <input type="text" name="name" value="<?php
                if (isset($name) AND ( $name <> "")) {
                    echo $name;
                }
                ?>" maxlength="100" class="required"/>
                       <?php
                       //if(empty($emailErr) && empty($nameErr) && empty($companyErr))
                       if (!empty($nameErr)) {
                           ?>
                    <label for="error" generated="true" class="error"><?php echo $nameErr; ?>.</label>
<?php } ?>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php
if (isset($email) AND ( $email <> "")) {
    echo $email;
}
?>" class="email required"/>
<?php if (!empty($emailErr)) { ?>
                    <label for="error" generated="true" class="error"><?php echo $emailErr; ?>.</label>
                <?php } ?>
            </p>
            <p>
                <label for="city">Company:</label>
                <input type="text" name="company" class="required" value="<?php
                if (isset($company) AND ( $company <> "")) {
                    echo $name;
                }
                ?>"/>
                <?php if (!empty($companyErr)) { ?>
                    <label for="error" generated="true" class="error"><?php echo $companyErr; ?>.</label>
<?php } ?>
            </p>
            <p>
                <label for="city">Job title:</label>
                <input type="text" name="job_title" class="required" value="<?php
                       if (isset($job_title) AND ( $job_title <> "")) {
                           echo $job_title;
                       }
                       ?>"/>
            </p>
            <p>
                <label for="city">Query Subject:</label>
                <input type="text" name="query_sub" value="<?php
                       if (isset($query_sub) AND ( $query_sub <> "")) {
                           echo $query_sub;
                       }
                       ?>"/>
            </p>
            <p>
                <label for="country">Query:</label>
                <textarea cols="30" rows="5" name="query"><?php
                       if ((isset($query)) && ($query != '')) {
                           echo $query;
                       }
                       ?></textarea>
            </p>
            <p>
                <label for="country">Attachment:</label>
                <input name="attachment" id="attachment" type="file" tabindex="5"/>(1 file only, max file size 1024kb.)

            </p>

            <p>
            <div style="clear:both; float:left; width:100%; text-align:left; margin:0px 0px 10px 0px;">
                <div style="clear:both; float:left; width:14%; margin:0px 0px 0px 0px;"><label for="scode">Security Code</label></div> 
                <div style="float:left; width:10%; text-align:left;"> <img border="0" id="captcha" src="_includes/image.php" alt="" align="bottom"></div>
                &nbsp;
                <div style="float:right; width:76%; text-align:left; margin:0px 0px 0px 0px;"><a href="JavaScript: new_captcha();"><img border="0" alt="" src="_images/refresh.png" style="vertical-align:top; margin-top:-5px; " title="Can't read the image? click here to refresh" /></a></div>
            </div>
            </p>
            <p>
                <label for="vcode">Verify Code:</label>
                <input type="text" name="letters_code" id="letters_code" value="" class="required" />
                <input type="hidden" name="contact_submit" value="1">
            </p>
            <input type="submit" name="submit"  value="Submit" class="button" />
        </form>
    </div><!--END CLASS form_class PART -->
</div>
<?php
include('_includes/footer.php');
?>
