<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <?php include('meta.php'); ?>
        <title>Caribbean Circle Star</title>
    </head>
    <body>
        <table border="1" class="TabMain"  cellpadding="0" cellspacing="0">
            <tr class="TRHeader">
                <td style="float:left;border:0px;">
                    <a href="<?php echo SITE_URL; ?>"><img src="<?php echo SITE_URL ?>images/logo.png"/></a> </td>
                <td style="float:right;border:0px; margin-right:30px; margin-top:7px;">
                    <a href="<?php echo SITE_URL; ?>" target="_blank"
                       style="font-family:Arial, Helvetica, sans-serif;
                       font-size:30px;
                       color:#000000;

                       ">

                        Go to the CCS site</a></td>
            </tr>
            <tr>
                <td>
                    <table border="0" style="border-collapse:collapse;" cellpadding="0" cellspacing="0">
                        <tr>
                            <td class="TDMenu">
                                <?php
                                if (isset($_SESSION['cms_login']) AND ( $_SESSION['cms_login'] == 1)) {
                                    ?>
                                    <ul class="ULMenu">
                                        <li><a href="search.php">Search</a></li>
                                        <li><a href="caribbean.php">Home</a></li>
                                        <li><a href="cms.php">CMS</a></li>
                                        <li><a href="change_password.php">Change Password</a></li>
                                        <li><a href="manage_music.php">Manage Music</a></li>
                                        <li><a href="media.php">Manage Media</a></li>
                                        <li><a href="order_manage.php">Order Manage</a></li>
                                        <li><a href="featured_artists_manage.php">Featured Artists Manage</a></li>
                                        <li><a href="member.php">Basic Member's</a></li>
                                        <li><a href="talent.php">Talent Member's</a></li>
                                        <li><a href="donate_record.php">Donate Record</a></li>
                                        <li><a href="contact_record.php">Contact Record</a></li>
                                        <li><a href="forum_record.php">Forum Record</a></li>
                                        <li><a href="log_out.php">Logout</a></li>
                                    </ul>
                                </td>
                            <?php } ?>
                            <td class="TDContent" valign="top">

                                <!-- Page Content Start -->
