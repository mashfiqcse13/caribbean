<?php
include('_includes/application-top.php');

//require_once 'member/securimage/securimage.php';
//$securimage = new Securimage();
$captcha = $_POST['ct_captcha'];
$errors = "";
if (isset($captcha) && !empty($captcha)) {
    /* if ($securimage->check($captcha) == false) {
      $errors = 'Incorrect security code entered';
      } */
    if (empty($_SESSION['security_code1']) || strcasecmp($_SESSION['security_code1'], $captcha) != 0) {
        $errors = 'Incorrect security code entered';
    }
    //END
}
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Submit') AND $errors == "") {
    $from_email2 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
    //$to_email2 = TO_ADMIN;
    //$to_email2 = "faisalnabbasi@hotmail.com";
    //$to_email2 = "bc090201786@gmail.com";
    $to_email2 = "admin@caribbeancirclestars.com";

    $message3 = "Dear Admin,<br /><br />
		          Below Details are submitted by " . $_POST['d_name'] . " wishing to donate." . "<br /><br />
							Name : " . $_POST['d_name'] . "<br />
							Email : " . $_POST['d_email'] . "<br />
							Amount : $" . $_POST['d_amount'] . "<br />
							Message : " . $_POST['message'] . "<br />";



    $message3.="Sincerely,<br />
							  The " . SITE_NAME . " Team." . "<br />";

    $subject2 = SITE_NAME . "Donation";

    # +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
    # Insert in to table here
    $name = $_POST['d_name'];
    $d_email = $_POST['d_email'];
    $d_amount = $_POST['d_amount'];
    $message = $_POST['message'];

    $Query = "INSERT INTO `tbl_donate`
                  (`name`,
                   `email`,
                   `amount`,
                   `message`,
                   `join_date`,
                   `join_time`)
      VALUES ('" . $_POST['d_name'] . "',
              '" . $_POST['d_email'] . "',
              '" . $_POST['d_amount'] . "',
              '" . $_POST['message'] . "',
              '" . date("Y-m-d") . "',
              '" . (date("h:i:s A")) . "');";

    mysql_query($Query);


    // To send HTML mail, the Content-type header must be set




    $headers = 'MIME-Version: 1.0' . "\r\n";
    $header.= "Content-Type: text/plain; charset=utf-8\r\n";
    $header.= "X-Priority: 1\r\n";
    // Additional headers
    //$headers .= 'To: Mary <mary@example.com>, Kelly <kelly@example.com>' . "\r\n";
    $headers .= 'From: ' . $from_email2 . "\r\n";
    //$headers .= 'Cc: faisalnabbasi@hotmail.com' . "\r\n";
    //$headers .= 'Cc: mz_arain08@hotmail.com' . "\r\n";
    // Mail it

    mail($to_email2, $subject2, $message3, $headers);


    //SendEMail($from_email2,$to_email2,$subject2,$message3);
    //include 'sendEmail.php';
    header("Location:donate.php?op=r");
}
include('_includes/header.php');
?>
<script type="text/javascript">
    $(document).ready(function () {
        $('#donate_form').validate()
    });

    $(document).ready(function () {

        $("#amount").keypress(function (e) {
            if (e.which != 8 && e.which != 0 && (e.which < 46 || e.which > 57) && e.which != 45)
            {
                return false;
            }
        });
    });

    function DisableBackButton() {
        window.history.forward()
    }
    DisableBackButton();
    window.onload = DisableBackButton;
    window.onpageshow = function (evt) {
        if (evt.persisted)
            DisableBackButton()
    }
    window.onunload = function () {
        void (0)
    }


    function new_captcha()
    {
        var c_currentTime = new Date();
        var c_miliseconds = c_currentTime.getTime();
        document.getElementById('captcha').src = '_includes/image.php?x=' + c_miliseconds;
    }

<?php
if ($_REQUEST['op'] == 'r') {
    ?>
        /*window.location.hash="no-back-button";
         window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
         window.location.hash="Again-No-back-button";
         window.onhashchange=function(){window.location.hash="no-back-button";}*/
        history.pushState({page: 1}, "title1", "#nbb");
        window.onhashchange = function (event) {
            window.location.hash = "nbb";

        };
    <?php
}
?>
</script>

<!--<script type="text/javascript">
function closeIt()
{
  return "Are you sure you want navigate away \n" + 
             "Thats a friendly reminder, You can ignore!";
}
window.onbeforeunload = closeIt;
</script>-->


<div class="content">
    <!--<h1>DONATE</h1>-->
    <h1><?php echo GetPageHeading('DONATE'); ?></h1>
    <p><?php echo GetPageText('DONATE'); ?></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <?php
        if (isset($_GET['op']) AND ( $_GET['op'] == "r")) {
            ?>

            <script>
                /*window.location.hash="no-back-button";
                 window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
                 window.onhashchange=function(){window.location.hash="no-back-button";}*/
            </script> 
            <div>
                <p class="msg">Your details has been successfully received, please click the donation button below to submit your donation</p><br />
                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                    <input type="hidden" name="cmd" value="_s-xclick">
                    <input type="hidden" name="hosted_button_id" value="7L4LATQS7L3DJ">
                    <input type="image" src="https://www.paypalobjects.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif" width="1" height="1">
                </form>
            </div>
            <?php
        } else {
            ?>
            <div>
                <p>Thanks for your donation please fill out this form.</p>
                <p><?php //echo GetPageText('DONATE');   ?></p>
                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" name="donate_form" id="donate_form">
                    <p>
                        <label for="">Name:</label>
                        <input type="text" name="d_name" value="<?php
                        if (isset($d_name) AND ( $d_name <> "")) {
                            echo $d_name;
                        }
                        ?>" maxlength="100" class="required"/>
                    </p>
                    <p>
                        <label for="email">Email:</label>
                        <input type="text" name="d_email" value="<?php
                        if (isset($d_email) AND ( $d_email <> "")) {
                            echo $d_email;
                        }
                        ?>" class="email required"/>
                    </p>
                    <p>
                        <label for="phone_no">Amount:</label>
                        <input  type="text" id="amount" name="d_amount" class="required" value="<?php
                        if (isset($d_amount) AND ( $d_amount <> "")) {
                            echo $d_amount;
                        }
                        ?>" />
                    </p>
                    <p>
                        <label for="country">Message:</label>
                        <textarea cols="30" rows="5" name="message"><?php
                        if ((isset($message)) && ($message != '')) {
                            echo $message;
                        }
                        ?></textarea>
                    </p>
                    <p>
                        <label for="code">Enter Code*:</label>

                                      <!--<img id="siimage" style="border: 1px solid #000; margin-right: 15px" src="member/securimage/securimage_show.php?sid=<?php echo md5(uniqid()) ?>" alt="CAPTCHA Image" align="left" />
                                      <object type="application/x-shockwave-flash" data="member/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=member/securimage/images/audio_icon.png&amp;audio_file=member/securimage/securimage_play.php" height="32" width="32">
                                      <param name="movie" value="member/securimage/securimage_play.swf?bgcol=#ffffff&amp;icon_file=member/securimage/images/audio_icon.png&amp;audio_file=member/securimage/securimage_play.php" />
                                      </object>-->
                        <img border="0" id="captcha" src="_includes/image.php" alt="" align="bottom">
                        &nbsp;
                        <!--<a tabindex="-1" style="border-style: none;" href="#" title="Refresh Image" onclick="document.getElementById('siimage').src = 'member/securimage/securimage_show.php?sid=' + Math.random(); this.blur(); return false"><img src="member/securimage/images/refresh.png" alt="Reload Image" height="32" width="32" onclick="this.blur()" align="bottom" border="0" /></a>--><a href="JavaScript: new_captcha();"><img border="0" alt="" src="_images/refresh.png" style="vertical-align:top; margin-top:8px; " title="Can't read the image? click here to refresh" /></a><br />
                        <input style="margin-left:140px;" class="required" type="text" name="ct_captcha" id="ct_captcha" size="12" maxlength="8" />
    <?php
    if (isset($errors) && !empty($errors)) {
        echo '<label for="ct_captcha" generated="true" class="error">Invalid Security Code.</label>';
    }
    ?>
                    </p>
                    <input type="hidden" name="donate_submit" value="1">
                    <input type="submit" name="submit"  value="Submit" class="button" />
                </form>
            </div>
<?php } ?>
    </div><!--END CLASS form_class PART -->
</div>


<?php
include('_includes/footer.php');
?>

