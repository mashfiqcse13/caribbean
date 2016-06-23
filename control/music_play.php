<?php
include('include/application_top.php');
//ChecktalentLogin();

if (!empty($_GET['filename'])) {
    $org_song = $_GET['filename'];
    ?>
    <audio controls autoplay="true">
        <source src="horse.ogg" type="audio/ogg">
        <source src="<?php echo $org_song; ?>" type="audio/mpeg">
        Your browser does not support the audio element.
    </audio> 
<?php } ?>