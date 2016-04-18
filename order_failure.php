<?php
include('_includes/application-top.php');
//CheckLoginForum();

$MSG = "Sorry, your payment is unsuccessful.<br/><a href=\"index.php\"><font style=\"color:#ffffff; font-size:15px;\"><b>Click here</b></font></a> to continue shopping.";


include('_includes/header.php');
?>

<div class="content"><!--START CLASS contant PART -->

    <?php
    echo "<p class='err' align='center'>" . $MSG . "</p>";
    ?>


    <div class="form_class"><!--START CLASS form_class PART -->



        <br />


    </div><!--START DIV CLASS profile_page_wraper-->	

</div><!--END CLASS form_class PART -->


</div><!--END CLASS contant PART -->

<?php include('_includes/footer.php'); ?>