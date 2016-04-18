<?php

include('include/application_top.php');
cmslogin();

if (!empty($_REQUEST['pg']) && !empty($_REQUEST['cnt'])) {
    $query = "INSERT INTO `tbl_contactrecords`(`contactid`,`page_name`,`created_at`) VALUES ('" . $_REQUEST['cnt'] . "','" . $_REQUEST['pg'] . "',NOW())";

    $result = mysql_query($query) or die(mysql_error());

    if ($result)
        echo 'true';
}
?>