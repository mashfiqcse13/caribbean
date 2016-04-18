<?php

$from = "info@digitalspot.ae"; // sender
$subject = "Caribbean Testing the email";
$message = "This is test message and hopefully it delivers";
// message lines should not exceed 70 characters (PHP rule), so wrap it
$message = wordwrap($message, 70);
// send mail
mail("bc090201786@gmail.com", $subject, $message, "From: $from\n");
echo "Thank you for sending us feedback";
?>