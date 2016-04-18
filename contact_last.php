<?php
include('_includes/application-top.php');
//session_start();
//require_once('contact.php'); 
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
<script src="http://malsup.github.com/jquery.form.js"></script>
<!-- All the jQuery event are writen in custom.js file -->
<script src="custom.js"></script>
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

    #progress { position:relative; width:675px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    #bar { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
    #percent { position:absolute; display:inline-block; top:3px; left:48%; }

    #progress1 { position:relative; width:675px; border: 1px solid #ddd; padding: 1px; border-radius: 3px; }
    #bar1 { background-color: #B4F5B4; width:0%; height:20px; border-radius: 3px; }
    #percent1 { position:absolute; display:inline-block; top:3px; left:48%; }

    .hide{display:none;}

    -->
</style>
<div class="content">
    <div class="mm"></div>
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

        <div id="message"></div>
        <p>Please fill the form below to reach us.</p>
        <form action="upload_file.php" method="post" name="donate_form" id="donate_form" enctype="multipart/form-data">
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
                    <option value="Publisher">Publisher</option>
                    <option value="singer/artiste">Singer/Artiste</option>
                    <option value="Sportsman">Sportsman</option>
                    <option value="Sportswoman">Sportswoman</option>
                    <option value="Writer">Writer</option>

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
                <input id="file" type="file" size="60" name="file" required>(1 file only pdf , doc & word file Accept Only)
            <div id="progress" class="hide">
                <div id="bar"></div>
                <div id="percent">0%</div >
            </div>

            </p>

            <p>
                <label for="country">Mp3/Video/Image:</label>
                <input name="music" id="music" type="file" tabindex="5"/>(1 file only, max file size 1024kb.)
            <div id="progress1" class="hide">
                <div id="bar1"></div>
                <div id="percent1">0%</div>
            </div>
            </p>

            <p>
            <div style="clear:both; float:left; width:100%; text-align:left; margin:0px 0px 10px 0px;">
                <div style="clear:both; float:left; width:14%; margin:10px 0px 0px 0px;"><label for="scode">Security Code</label></div>
                <div style="float:left; width:10%; text-align:left;"><img src="_includes/captcha-code-file.php?rand=<?php echo rand(); ?>" id='captchaimg' ></div>
                <div style="float:right; width:76%; text-align:left; margin:15px 0px 0px 0px;"><a href='javascript: refreshCaptcha();'><img src="_images/refresh.png" width="16px" height="16px" border="0" title="Can't read the image? click here to refresh" /></a></div>
            </div>
            </p>
            <p>
                <input type="hidden" name="cap" value="_includes/captcha-code-file.php?rand=<?php echo rand(); ?>" />
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

