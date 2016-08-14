<?php
include('_includes/application-top.php');
session_start();
//require_once('contact.php'); 
?>

<?php
if ((isset($_POST['submit'])) && ($_POST['submit'] == "Submit")) {
    //echo $_SESSION['letters_code'];
    {

        extract($_POST);

        // Read POST request params into global vars
        // FILL IN YOUR EMAIL
        //$to = "dev1.solutiononline@gmail.com";
        //	$sendCc = "pratikdutta@gmail.com";
        $to = "" . TO_ADMIN . "";
        $sendCc = "" . TO_ADMIN . "";
        //$subject = trim($_POST['subject']);
        //$namefrom = trim($_POST['namefrom']);
        //$emailfrom = trim($_POST['emailfrom']);
        //$comments = trim($_POST['comments']);
        // Allowed file types. add file extensions WITHOUT the dot.
        $allowtypes = array("zip", "rar", "doc", "pdf", "docx", "ppt", "pptx", "jpg", "jpeg", "gif");

        // Require a file to be attached: false = Do not allow attachments true = allow only 1 file to be attached
        $requirefile = "true";

        // Maximum file size for attachments in KB NOT Bytes for simplicity. MAKE SURE your php.ini can handel it,
        // post_max_size, upload_max_filesize, file_uploads, max_execution_time!
        // 2048kb = 2MB,       1024kb = 1MB,     512kb = 1/2MB etc..
        $max_file_size = "1024";

        // Thank you message
        $thanksmessage = "Your email has been sent, we will respond shortly.";

        $errors = array(); //Initialize error array
        //checks for a name
        if (empty($name)) {
            $errors[] = 'You forgot to enter your name';
        }

        $contents = "<br /><br />Dear Admin,<br /><br />
		          		Below Details are submitted by " . $name . "<br /><br />
									Name : " . $name . "<br />
									Email : " . $email . "<br />
									Company : " . $company . "<br />
									Job title : " . $job_title . "<br />
									Query Subject : " . $query_sub . "<br />
									Query : " . $query . "<br />";
        $contents.="Sincerely,<br />
							  		The " . SITE_NAME . " Team" . "<br />";

        //checks for an email
        //if (!empty($_POST['emailfrom']) ) {
        //		//$errors[]='You forgot to enter your email';
        ////		} else {
        //
			//		if (!eregi ('^[[:alnum:]][a-z0-9_\.\-]*@[a-z0-9\.\-]+\.[a-z]{2,4}$', stripslashes(trim($_POST['emailfrom'])))) {
        //			$errors[]='Please enter a valid email address';
        //		} // if eregi
        //	} // if empty email
        //checks for a subject
        //if (empty($_POST['subject']) ) {
        //		$errors[]='You forgot to enter a subject';
        //		}
        //checks for a message
        //if (empty($_POST['comments']) ) {
        //		$errors[]='You forgot to enter your comments';
        //		}
        // checks for required file
        // http://amiworks.co.in/talk/handling-file-uploads-in-php/
        //if($requirefile=="true") {
        //		if($_FILES['attachment']['error']==4) {
        //			$errors[]='You forgot to attach a file';
        //		}
        //	}
        //checks attachment file
        // checks that we have a file
        if ((!empty($_FILES["attachment"])) && ($_FILES['attachment']['error'] == 0)) {
            // basename -- Returns filename component of path
            $filename = basename($_FILES['attachment']['name']);
            $ext = substr($filename, strrpos($filename, '.') + 1);
            $filesize = $_FILES['attachment']['size'];
            $max_bytes = $max_file_size * 1024;

            //Check if the file type uploaded is a valid file type. 
            //if (!in_array($ext, $allowtypes)) {
            //				$errors[]="Invalid extension for your file: <strong>".$filename."</strong>";
            //				
            //		// check the size of each file
            //		} else
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

            // Headers
            $headers = "From: " . FROM_EMAIL . "\n";
            $headers .= "Cc: " . $sendCc . " ";

            // create a boundary string. It must be unique
            $semi_rand = md5(time());
            $mime_boundary = "==Multipart_Boundary_x{$semi_rand}x";

            // Add the headers for a file attachment
            $headers .= "\nMIME-Version: 1.0\n" .
                    "Content-Type: multipart/mixed;\n" .
                    " boundary=\"{$mime_boundary}\"";

            // Add a multipart boundary above the plain message
            $message = "This is a multi-part message in MIME format.\n\n";
            $message.="--{$mime_boundary}\n";
            $message.="Content-Type: text/html; charset=\"iso-8859-1\"\n";
            $message.="Content-Transfer-Encoding: 7bit\n\n";
            $message.="From: " . $name . "\n";
            $message.="" . $contents . "\n\n";

            if (is_uploaded_file($fileatt)) {
                // Read the file to be attached ('rb' = read binary)
                $file = fopen($fileatt, 'rb');
                $data = fread($file, filesize($fileatt));
                fclose($file);

                // Base64 encode the file data
                $data = chunk_split(base64_encode($data));

                // Add file attachment to the message
                $message .= "--{$mime_boundary}\n" .
                        "Content-Type: {$fileatt_type};\n" .
                        " name=\"{$fileatt_name}\"\n" .
                        //"Content-Disposition: attachment;\n" .
                        //" filename=\"{$fileatt_name}\"\n" .
                        "Content-Transfer-Encoding: base64\n\n" .
                        $data . "\n\n" .
                        "--{$mime_boundary}--\n";
            }


            // Send the completed message

            $envs = array("HTTP_USER_AGENT", "REMOTE_ADDR", "REMOTE_HOST");
            foreach ($envs as $env)
                $message .= "$env: $_SERVER[$env]\n";

            //if($subject==''){
//						$subject="Expression regarding sexual assault";
//			
//					}
            $subject = SITE_NAME . "Contact";

            if (!mail($to, $subject, $message, $headers)) {
                exit("Mail could not be sent. Sorry! An error has occurred, please report this to the website administrator.\n");
            } else {
                mail($sendCc, $subject, $message, $headers);
                //echo '<div id="formfeedback"><h3>Thank You!</h3><p>'. $thanksmessage .'</p></div>';
            } // end of if !mail
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
    function refreshCaptcha(){
    var img = document.images['captchaimg'];
    img.src = img.src.substring(0,img.src.lastIndexOf("?"))+"?rand="+Math.random()*1000;
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
            if ((isset($thanksmessage)) && ($thanksmessage != "")) {
                echo '<div id="formfeedback"><p class="msg">' . $thanksmessage . '</p></div>';
            }
            ?>
            <p>
                <label for="">Name:</label>
                <input type="text" name="name" value="<?php
                if (isset($last_name) AND ( $last_name <> "")) {
                    echo $last_name;
                }
                ?>" maxlength="100" class="required"/>
            </p>
            <p>
                <label for="email">Email:</label>
                <input type="text" name="email" value="<?php
                if (isset($email) AND ( $email <> "")) {
                    echo $email;
                }
                ?>" class="email required"/>
            </p>
            <p>
                <label for="city">Company:</label>
                <input type="text" name="company" class="required" value="<?php
                if (isset($city) AND ( $city <> "")) {
                    echo $city;
                }
                ?>"/>
            </p>
            <p>
                <label for="city">Job title:</label>
                <select name="country" id="location" class="required" onchange="correct_number()">
                    <option value="">-- Select Job--</option>
                    <option value="actor/actress">Actor/Actress</option>
                    <option value="Advertisers">Advertisers</option>
                    <option value="Artist">Artist</option>
                    <option value="Athlete">Athlete</option>
                    <option value="Authors">Authors</option>

                    <option value="Comedian">Comedian</option>
                    <option value="craftsman/craftswoman">Craftsman/ Craftswoman</option>
                    <option value="Dancer">Dancer</option>
                    <option value="Manager">Manager</option>
                    <option value="Musicians">Musicians</option>
                    <option value="Model">Model</option>
                    <option value="Photography">Photography</option>
                    <option value="Poets">Poets</option>
                    <option value="Preformer">Preformer</option>
                    <option value="Promoter">Promoter</option>
                    <option value="singer/artiste">Singer/Artiste</option>
                    <option value="Sportsman">Sportsman</option>
                    <option value="Sportswoman">Sportswoman</option>
                    <option value="Writer">Writer</option>
                    <option value="Others">Others</option>

                </select>
            </p>
            <p>
                <label for="city">Artist Name:</label>
                <input type="text" name="aname" required value="<?php //if(isset($city) AND ($city<>"")){ echo $city; }   ?>"/>
            </p>
            <p>
                <label for="city">Title Of Work:</label>
                <input type="text" name="towork" required value="<?php //if(isset($city) AND ($city<>"")){ echo $city; }   ?>"/>
            </p>

            <p>
                <label for="city">Genre:</label>
                <select name="country" id="location" class="required" >
                    <option value="">-- Select Genre--</option>
                    <option value="Dancehall">Dancehall</option>
                    <option value="Deejays">Deejays</option>
                    <option value="Dub">Dub</option>
                    <option value="Lovers Rock">Lovers Rock</option>
                    <option value="Nyabhingi">Nyabhingi</option>
                    <option value="Ragga">Ragga</option>
                    <option value="Reggae">Reggae</option>
                    <option value="Roots reggae">Roots reggae</option>
                    <option value="Rocksteady">Rocksteady</option>
                    <option value="Rumble">Rumble</option>
                    <option value="Ska">Ska</option>
                    <option value="" disabled="disabled">----------------------</option>
                    <option value="Calypso">Calypso</option>
                    <option value="Caribbean Folk">Caribbean Folk</option>
                    <option value="Chutney ">Chutney </option>
                    <option value="Chutney Soca">Chutney Soca</option>
                    <option value="Publisher">Publisher</option>
                    <option value="Extempo">Extempo</option>
                    <option value="Kaiso">Kaiso</option>
                    <option value="Parang soca">Parang soca</option>
                    <option value="Rapso Soca">Rapso Soca</option>
                    <option value="Soca">Soca</option>
                    <option value="Steelpan">Steelpan</option>

                </select>
            </p>

            <p>
                <label for="city">Query Subject:</label>
                <input type="text" name="query_sub" value="<?php
                    if (isset($city) AND ( $city <> "")) {
                        echo $city;
                    }
                    ?>"/>
            </p>
            <p>
                <label for="country">Query:</label>
                <textarea cols="30" rows="5" name="query"><?php
                    if ((isset($enquery)) && ($enquery != '')) {
                        echo $enquery;
                    }
                    ?></textarea>
            </p>
            <p>
                <label for="country">Attachment:</label>
                <input name="attachment" id="attachment" type="file" tabindex="5"/>(1 file only, max file size 1024kb.)

            </p>

            <p>
                <label for="country">Mp3/Video/Image:</label>
                <input name="attachment" id="attachment" type="file" tabindex="5"/>(1 file only, max file size 1024kb.)

            </p>

            <p>
            <div style="clear:both; float:left; width:100%; text-align:left; margin:0px 0px 10px 0px;">
                <div style="clear:both; float:left; width:14%; margin:10px 0px 0px 0px;"><label for="scode">Security Code</label></div>
                <div style="float:left; width:10%; text-align:left;"><img src="_includes/captcha-code-file.php?rand=<?php echo rand(); ?>" id='captchaimg' ></div>
                <div style="float:right; width:76%; text-align:left; margin:15px 0px 0px 0px;"><a href='javascript: refreshCaptcha();'><img src="_images/refresh.png" width="16px" height="16px" border="0" title="Can't read the image? click here to refresh" /></a></div>
            </div>
            </p>
            <p>
                <label for="vcode">Verify Code:</label>
                <input type="text" name="letters_code" id="letters_code" value="" class="required" />
            </p>
            <input type="submit" name="submit"  value="Submit" class="button" />
        </form>
    </div><!--END CLASS form_class PART --> 
</div>
<?php
include('_includes/footer.php');
?>

