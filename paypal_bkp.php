<?php

/*  PHP Paypal IPN Integration Class Demonstration File
 *  4.16.2005 - Micah Carrick, email@micahcarrick.com
 *
 *  This file demonstrates the usage of paypal.class.php, a class designed  
 *  to aid in the interfacing between your website, paypal, and the instant
 *  payment notification (IPN) interface.  This single file serves as 4 
 *  virtual pages depending on the "action" varialble passed in the URL. It's
 *  the processing page which processes form data being submitted to paypal, it
 *  is the page paypal returns a user to upon success, it's the page paypal
 *  returns a user to upon canceling an order, and finally, it's the page that
 *  handles the IPN request from Paypal.
 *
 *  I tried to comment this file, aswell as the acutall class file, as well as
 *  I possibly could.  Please email me with questions, comments, and suggestions.
 *  See the header of paypal.class.php for additional resources and information.
 */

// Setup class
include('_includes/application-top.php');
include('_includes/header.php');
require_once('paypal.class.php');

if (isset($_SESSION["talent_id"])) {
    $uid = $_SESSION["talent_id"];
} else if (isset($_SESSION["user_id"])) {
    $uid = $_SESSION["user_id"];
}
$sql_p = "SELECT * FROM tbl_products WHERE `id`='" . $_GET['p'] . "'";
$res_p = mysqli_query($link,$sql_p);
$row_p = mysqli_fetch_array($res_p);

$sql_order_table = "SELECT * FROM tbl_orders WHERE `id`='" . $_GET['o'] . "'";
$res_order_table = mysqli_query($link,$sql_order_table);
$row_order_table = mysqli_fetch_array($res_order_table);

$amount = number_format($row_order_table['total_amt']);

// include the class file
$p = new paypal_class;             // initiate an instance of the class
$p->paypal_url = 'https://www.sandbox.paypal.com/cgi-bin/webscr';   // testing paypal url
//$p->paypal_url = 'https://www.paypal.com/cgi-bin/webscr';     // paypal url
// setup a variable for this script (ie: 'http://www.micahcarrick.com/paypal.php')
$this_script = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['PHP_SELF'];

// if there is not action variable, set the default action of 'process'
if (empty($_GET['action']))
    $_GET['action'] = 'process';

switch ($_GET['action']) {

    case 'process':      // Process and order...
        // There should be no output at this point.  To process the POST data,
        // the submit_paypal_post() function will output all the HTML tags which
        // contains a FORM which is submited instantaneously using the BODY onload
        // attribute.  In other words, don't echo or printf anything when you're
        // going to be calling the submit_paypal_post() function.
        // This is where you would have your form validation  and all that jazz.
        // You would take your POST vars and load them into the class like below,
        // only using the POST values instead of constant string expressions.
        // For example, after ensureing all the POST variables from your custom
        // order form are valid, you might have:
        //
      // $p->add_field('first_name', $_POST['first_name']);
        // $p->add_field('last_name', $_POST['last_name']);
        $custom_var = $_GET['p'] . ":" . $uid . ":" . $_GET['o'];
        $p->add_field('business', ADMIN_PAYPAL_ID);
        $p->add_field('return', $this_script . '?action=success');
        $p->add_field('cancel_return', $this_script . '?action=cancel');
        $p->add_field('notify_url', $this_script . '?action=ipn');
        $p->add_field('item_name', 'Product Name : ' . $row_p['product_name']);
        $p->add_field('amount', $amount);
        $p->add_field('currency_code', CURRENCY_CODE);
        $p->add_field('custom', $custom_var);
        $p->add_field('quantity', '1');


        $p->submit_paypal_post(); // submit the fields to paypal
        //$p->dump_fields();      // for debugging, output a table of all the fields
        break;

    case 'success':      // Order was successful...
        // This is where you would probably want to thank the user for their order
        // or what have you.  The order information at this point is in POST 
        // variables.  However, you don't want to "process" the order until you
        // get validation from the IPN.  That's where you would have the code to
        // email an admin, update the database with payment status, activate a
        // membership, etc.  
        //header("Location: order_success.php");
        ?>
        <script type="text/javascript">

            window.location = "order_success.php";

        </script>
        <?php

        // You could also simply re-direct them to another page, or your own 
        // order status page which presents the user with the status of their
        // order based on a database (which can be modified with the IPN code 
        // below).

        break;

    case 'cancel':       // Order was canceled...
        // The order was canceled before being completed.
        //header("Location:order_failure.php"); 
        ?>

        <script type="text/javascript">

            window.location = "order_success.php";

        </script>
        <?php

        break;

    case 'ipn':          // Paypal is calling page for IPN validation...
        // It's important to remember that paypal calling this script.  There
        // is no output here.  This is where you validate the IPN data and if it's
        // valid, update your database to signify that the user has payed.  If
        // you try and use an echo or printf function here it's not going to do you
        // a bit of good.  This is on the "backend".  That is why, by default, the
        // class logs all IPN data to a text file.

        if ($p->validate_ipn()) {

            // Payment has been recieved and IPN is verified.  This is where you
            // update your database to activate or process the order, or setup
            // the database with the user's order details, email an administrator,
            // etc.  You can access a slew of information via the ipn_data() array.
            // Check the paypal documentation for specifics on what information
            // is available in the IPN POST variables.  Basically, all the POST vars
            // which paypal sends, which we send back for validation, are now stored
            // in the ipn_data() array.
            // For this example, we'll just email ourselves ALL the data.
            $pieces1 = $p->ipn_data['custom'];

            /* $from_email = "surajit1990dhk@gmail.com";
              $to_email = "surajit@solutiononline.co.in";
              $subject = "false";
              $message = $pieces;
              SendEMail($from_email,$to_email,$subject,$message); */
            $pieces = explode(":", $pieces1);
            $product_id = $pieces[0];
            $user_id = $pieces[1];
            $order_id = $pieces[2];

            $sql_p = "SELECT * FROM tbl_products WHERE `id`='$product_id'";
            $res_p = mysqli_query($link,$sql_p);
            $row_p = mysqli_fetch_array($res_p);

            $sql_u = "SELECT * FROM tbl_users WHERE `id`='$user_id'";
            $res_u = mysqli_query($link,$sql_u);
            $row_u = mysqli_fetch_array($res_u);

            $sql_o = "SELECT * FROM tbl_orders WHERE `id`='$order_id'";
            $res_o = mysqli_query($link,$sql_o);
            $row_o = mysqli_fetch_array($res_o);

            $sql_s = "SELECT * FROM tbl_order_shipping WHERE `order_id`='$order_id'";
            $res_s = mysqli_query($link,$sql_s);
            $row_s = mysqli_fetch_array($res_s);

            $sql_seller = "SELECT * FROM tbl_users WHERE `id`='" . $row_p['uid'] . "'";
            $res_seller = mysqli_query($link,$sql_seller);
            $row_seller = mysqli_fetch_array($res_seller);

            $ccd_amount = number_format(($row_o['total_amt']), 2);

            $sql = "UPDATE tbl_orders SET `order_status`='1',`payment_status`='1' WHERE `id`='" . $order_id . "'";
            $res = mysqli_query($link,$sql);

            ////////////////////// BUYER MAIL //////////////////////
            ////////////////////// BUYER MAIL //////////////////////

            $from_email = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
            $to_email = $row_u['email'];

            $message1 = "Hello " . $row_u['first_name'] . " " . $row_u['last_name'] . ",<br><br>
									 Your payment is successful.<br /><br />
									 <strong>Your Order Details Below</strong><br />
									 Order Id: " . $order_id . "<br />
									 Payment Date: " . date('d/m/Y', strtotime($row_o['order_date'])) . "<br />
									 Payment Amount: $" . $ccd_amount . "<br />
									 Product Name: " . $row_p['product_name'] . "<br />
									 <br />";

            /* if($row_p['shipping']==1){

              $message1.="<strong>Your Shipping Details Below</strong><br />
              Name: " . $row_s['name'] . "<br />
              Address: " . nl2br($row_s['address']) . "<br />
              Zip Code: " . $row_s['zip'] . "<br />
              City: " . $row_s['city'] . "<br />
              State: " . $row_s['state'] . "<br />
              Country: " . $countries_array1[$row_s['country']] . "<br /><br />
              Please <a href=" . SITE_URL . "member/login.php>login and see your order history</a><br /><br />";
              } */

            $message1.="Sincerely,<br />
							  The " . SITE_NAME . " Team";

            $subject = "Congratulations!!!Payment Successfully for " . $row_p['product_name'] . " .";



            SendEMail($from_email, $to_email, $subject, $message1);


            ////////////////////// SELLER MAIL //////////////////////
            ////////////////////// SELLER MAIL //////////////////////

            $from_email1 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
            $to_email1 = $row_seller['email'];

            $message2 = "Hello " . $row_seller['first_name'] . " " . $row_seller['last_name'] . ",<br><br>
									 You have received order for " . $row_p['product_name'] . " from " . $row_u['username'] . "<br />
									 .<br /> 
									 Please <a href=" . SITE_URL . "talents/login.php>login and see your order under Order Manage</a><br /><br />";

            $message2.="Sincerely,<br />
									  The " . SITE_NAME . " Team";

            $subject1 = "Congratulation!!! Order for " . $row_p['product_name'] . " by " . $row_u['username'] . " ";

            SendEMail($from_email1, $to_email1, $subject1, $message2);


            ////////////////////// ADMIN MAIL //////////////////////
            ////////////////////// ADMIN MAIL //////////////////////

            $from_email2 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
            $to_email2 = TO_ADMIN;

            $message3 = "Hello " . SITE_NAME . "<br /><br />
						  		Payment Amount: $" . $ccd_amount . "<br />
									Payment Date: " . date('d/m/Y', strtotime($row_o['order_date'])) . "<br /><br />";

            $message3.="Sincerely,<br />
									  The " . SITE_NAME . " Team";

            $subject2 = "CCS Product Purchase " . $row_p['product_name'] . " .";



            SendEMail($from_email2, $to_email2, $subject2, $message3);
        }
        break;
}
?>