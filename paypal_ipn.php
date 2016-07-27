<?php

include('_includes/application-top.php');

if (!isset($_POST["txn_id"]) && !isset($_POST["txn_type"])) {

    // Request from step 3
} else {
    // Response from Paypal
    // read the post from PayPal system and add 'cmd'
    $from_email = "surajit1990dhk@gmail.com";
    $to_email = "surajit@solutiononline.co.in";
    $subject = "start";
    $message = "hello carebbean circle star";
    SendEMail($from_email, $to_email, $subject, $message);
    $req = 'cmd=_notify-validate';

    foreach ($_POST as $key => $value) {

        $value = urlencode(stripslashes($value));

        $value = preg_replace('/(.*[^%^0^D])(%0A)(.*)/i', '${1}%0D%0A${3}', $value); // IPN fix

        $req .= "&$key=$value";
    }

    // assign posted variables to local variables

    $data['item_name'] = $_POST['item_name'];

    $data['item_number'] = $_POST['item_number'];

    $data['payment_status'] = $_POST['payment_status'];

    $data['payment_amount'] = $_POST['mc_gross'];

    $data['payment_currency'] = $_POST['mc_currency'];

    $data['txn_id'] = $_POST['txn_id'];

    $data['receiver_email'] = $_POST['receiver_email'];

    $data['payer_email'] = $_POST['payer_email'];

    $data['custom'] = $_POST['custom'];

    // post back to PayPal system to validate

    $header = "POST /cgi-bin/webscr HTTP/1.0\r\n";

    $header .= "Content-Type: application/x-www-form-urlencoded\r\n";

    $header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

    $fp = fsockopen('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);

    if (!$fp) {

        return false;
    } else {


        fputs($fp, $header . $req);

        while (!feof($fp)) {

            $res. = fgets($fp, 1024);


            $from_email = "surajit1990dhk@gmail.com";
            $to_email = "surajit@solutiononline.co.in";
            $subject = "start";
            $message = $res;
            SendEMail($from_email, $to_email, $subject, $message);
            /* if (strcmp ($res, "VERIFIED") == 0) { */
            if (stristr("VERIFIED", $res)) {


                $pieces = explode(":", $data['custom']);

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

                $sql = "UPDATE tbl_orders SET `order_status`='1',`payment_status`='1' WHERE `id`='" . $order_id . "'";
                $res = mysqli_query($link,$sql);

                $from_email = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
                $to_email = $row_u['email'];

                $message1 = "Hello " . $row_u['first_name'] . " " . $row_u['last_name'] . ",<br><br>
									 Your payment is successful<br /><br />
									 <strong>Your Order Details Below</strong><br />
									 Order Id: " . $order_id . "<br />
									 Payment Amount: $" . number_format($row_o['p_amt'], 2) . "<br />
									 Shipping Amount: $" . number_format($row_o['shipping_amt'], 2) . "<br />
									 Total Amount: $" . number_format($row_o['total_amt'], 2) . "<br />
									 Product Name: " . $row_p['product_name'] . "<br />
									 Payment Date: " . date('d/m/Y', strtotime($row_o['order_date'])) . "<br /><br />";

                if ($row_p['shipping'] == 1) {

                    $message1 = "<strong>Your Shipping Details Below</strong><br />
									 Name: " . $row_s['name'] . "<br />
									 Address: " . nl2br($row_s['address']) . "<br />
									 Zip Code: " . $row_s['zip'] . "<br />
									 City: " . $row_s['city'] . "<br />
									 State: " . $row_s['state'] . "<br />
									 Country: " . $countries_array1[$row_s['country']] . "<br /><br />
									 Please <a href=" . SITE_URL . "member/login.php>login and see your order history</a><br /><br />";
                }

                $message1.="Sincerely,<br />
							  The " . SITE_NAME . " Team";

                $subject = SITE_NAME . "[Congratulation!!!Payment Successfully for " . $row1['product_name'] . " product";



                SendEMail($from_email, $to_email, $subject, $message1);

                $from_email1 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
                $to_email1 = $row_seller['email'];

                $message2 = "Hello " . $row_seller['first_name'] . " " . $row_seller['last_name'] . ",<br><br>
									 You sold " . $row_p['product_name'] . " to " . $row_u['username'] . "<br />
									 Payment Amount: $" . number_format($row_o['p_amt'], 2) . "<br /><br />
									 Please <a href=" . SITE_URL . "talents/login.php>login and see your manage order history</a><br /><br />";

                $message2.="Sincerely,<br />
									  The " . SITE_NAME . " Team";

                $subject1 = SITE_NAME . "[Congratulation!!! You sold " . $row_p['product_name'] . " product to " . $row_u['username'] . " ";

                SendEMail($from_email1, $to_email1, $subject1, $message2);

                $from_email2 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
                $to_email2 = TO_ADMIN;

                $message3 = "Hello " . SITE_NAME . "<br /><br />
						  One Product sold from " . $row_seller['username'] . " to " . $row_u['username'] . "<br />
									Payment Amount: $" . number_format($row_o['p_amt'], 2) . "<br />
									Shipping Amount: $" . number_format($row_o['shipping_amt'], 2) . "<br />
									Total Amount: $" . number_format($row_o['total_amt'], 2) . "<br />
									Product Name: " . $row_p['product_name'] . "<br />
									Payment Date: " . date('d/m/Y', strtotime($row_o['order_date'])) . "<br /><br />";

                $message3.="Sincerely,<br />
									  The " . SITE_NAME . " Team";

                $subject2 = SITE_NAME . " Product Purchased ";



                SendEMail($from_email2, $to_email2, $subject2, $message3);
            }/* else if (strcmp ($res, "INVALID") == 0) { */ else {
                
            }
        }

        fclose($fp);
    }
}
?>