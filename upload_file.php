<?php

include('_includes/application-top.php');
//session_start();
//require_once('contact.php'); 
?>


<?php

if (isset($_SESSION['file1'])) {
    $name = $_REQUEST['name'];
    $email = $_REQUEST['email'];
    $company = $_REQUEST['company'];
    $country = $_REQUEST['country'];
    $aname = $_REQUEST['aname'];
    $towork = $_REQUEST['towork'];
    $genre = $_REQUEST['genre'];
    $query_sub = $_REQUEST['query_sub'];
    $query = $_REQUEST['query'];
    $file1 = $_SESSION['file1'];
    $file2 = $_SESSION['file2'];

    $contact = mysql_query("INSERT INTO contact SET name='" . $name . "' , email='" . $email . "' , company='" . $company . "' , country='" . $country . "' , aname='" . $aname . "' , towork='" . $towork . "' , genre='" . $genre . "' , query_sub='" . $query_sub . "' , query='" . $query . "' , file1='" . $file1 . "' , file2='" . $file2 . "'");
    unset($_SESSION['file1']);
    header('location:contact.php?smsg=Contact Message Recived');

    //echo " File :".$_REQUEST["abc"]; 
} else {
    header('location:contact.php?smsg=Not Recived');
}
?>