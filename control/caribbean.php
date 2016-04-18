<?php
include('include/application_top.php');
cmslogin();
?>
<?php include('include/header.php'); ?>

<!--<h1>WELCOME TO ADMIN CARIBBEN CIRCLE STARS ......</h1>-->
<h1>Welcome to your Admin Control Panel...</h1>

<?php
if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
    echo "<p class='err'>Record Deleted Sucessfully</p>";
}
?>

<?php include('include/footer.php'); ?>
