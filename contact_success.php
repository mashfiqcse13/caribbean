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
?>

<?php

/* if($_REQUEST['i'] == "1")
  {
  header("Location: contact_success.php?i=2");
  } */
?>
<?php include('_includes/header.php'); ?>
<script language="javascript" type="text/javascript">
    /*window.location.hash="no-back-button";
     window.location.hash="Again-No-back-button";//again because google chrome don't insert first hash into history
     window.location.hash="Again-No-back-button";
     window.onhashchange=function(){window.location.hash="no-back-button";}*/
    history.pushState({page: 1}, "title 1", "#nbb");
    window.onhashchange = function (event) {
        window.location.hash = "nbb";

    };
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


<div class="content"><!--START CLASS contant PART -->
    <h2><p class='msg'>Your email has been sent, we will respond shortly.</p></h2>


</div>
<?php

include('_includes/footer.php');
?>
