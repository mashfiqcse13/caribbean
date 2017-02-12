<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>

<style>
     .file_sorter {
        list-style: outside none none;
    }
    .file_sorter > li {
        border-left: 2px solid #444444;
        color: #FF9900;
        display: inline-block;
        margin: 0 5px;
        padding: 0 20px;
    }
    .file_sorter > li:first-child {
        border-left: none;
    }
    
</style>





 <ul class="file_sorter">
    <li><a href="change_password.php">Change Pasword</a></li>
    <li><a href="add_admin_avatar.php">Add Admin Avatar</a></li>
</ul>















<?php include('include/footer.php'); ?>