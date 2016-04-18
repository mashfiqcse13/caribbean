<?php include('include/application_top.php'); ?>

<?php include('include/header.php'); ?>
<?php
if ($_REQUEST['op'] == "invalid") {
    ?>
    <div style="width:470px;padding:10px;margin-left: 50px;font-weight: bold">
        <p class="err">Your Session has Expired,Please Login Again.
            <a style="color:Yellow;font-weight: bold;" href="/control/index.php"> Click Here Login</a>
        </p>

    </div>
<?php } ?>
<?php include('include/footer.php'); ?>
