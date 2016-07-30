<?php
include('_includes/application-top.php');
//include('_includes/paypalpayment.php');
CheckLoginForum();
if (isset($_SESSION["talent_id"])) {
    $uid = $_SESSION["talent_id"];
} else if (isset($_SESSION["user_id"])) {
    $uid = $_SESSION["user_id"];
}

if ((isset($_GET['order'])) && ($_GET['order'] == 1)) {

    $sql = "UPDATE tbl_orders " .
            "SET order_status=1, " .
            "payment_status=1 " .
            "WHERE 1=1 AND id=" . $_GET['id'] . " ";

    $result = mysqli_query($link,$sql) or die(mysqli_error($link,));



    $data1 = getAnyTableWhereData("tbl_users", "AND id=" . $uid . " ");

    $sql1 = "SELECT o.id AS OID, o.order_date, o.uid, o.seller_id, o.p_id, o.p_amt, o.shipping_amt, o.total_amt, " .
            "os.name, os.address, os.zip, os.city, os.state, os.country, p.product_name, p.shipping " .
            "FROM tbl_orders AS o " .
            "LEFT OUTER JOIN tbl_order_shipping AS os " .
            "ON os.order_id=o.id " .
            "LEFT OUTER JOIN tbl_products AS p " .
            "ON p.id=o.p_id " .
            "WHERE 1=1 AND o.uid=" . $uid . " AND o.id=" . $_GET['id'] . " ";

    $result1 = mysqli_query($link,$sql1) or die(mysqli_error($link,));

    $row1 = mysqli_fetch_array($result1);

    $from_email = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
    $to_email = $data1['email'];

    $message1 = "Hello " . $data1['first_name'] . " " . $data1['last_name'] . ",<br><br>
							 Your payment is successful<br /><br />
							 <strong>Your Order Details Below</strong><br />
							 Order Id: " . $row1['OID'] . "<br />
							 Payment Amount: $" . number_format($row1['p_amt'], 2) . "<br />
							 Shipping Amount: $" . number_format($row1['shipping_amt'], 2) . "<br />
							 Total Amount: $" . number_format($row1['total_amt'], 2) . "<br />
							 Product Name: " . $row1['product_name'] . "<br />
							 Payment Date: " . date('d/m/Y', strtotime($row1['order_date'])) . "<br /><br />";

    if ($row1['shipping'] == 1) {

        $message1 = "<strong>Your Shipping Details Below</strong><br />
							 Name: " . $row1['name'] . "<br />
							 Address: " . nl2br($row1['address']) . "<br />
							 Zip Code: " . $row1['zip'] . "<br />
							 City: " . $row1['city'] . "<br />
							 State: " . $row1['state'] . "<br />
							 Country: " . $countries_array1[$row1['country']] . "<br /><br />
							 Please <a href=" . SITE_URL . "member/login.php>login and see your order history</a><br /><br />";
    }

    $message1.="Sincerely,<br />
							  The " . SITE_NAME . " Team";

    $subject = SITE_NAME . "[Congratulation!!!Payment Successfully for " . $row1['product_name'] . " product";

    SendEMail($from_email, $to_email, $subject, $message1);

    $sql2 = "SELECT p.id AS PID, p.product_name, u.first_name, u.last_name, u.username, u.email " .
            "FROM tbl_products AS p " .
            "LEFT OUTER JOIN tbl_users AS u " .
            "ON u.id=p.uid 	 " .
            "WHERE 1=1 AND p.id=" . $row1['p_id'] . " ";

    $result2 = mysqli_query($link,$sql2) or die(mysqli_error($link,));

    $row2 = mysqli_fetch_array($result2);

    $from_email1 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
    $to_email1 = $row2['email'];

    $message2 = "Hello " . $row2['first_name'] . " " . $row2['last_name'] . ",<br><br>
							 You sold " . $row2['product_name'] . " to " . $data1['username'] . "<br />
							 Payment Amount: $" . number_format($row1['p_amt'], 2) . "<br /><br />
							 Please <a href=" . SITE_URL . "talents/login.php>login and see your manage order history</a><br /><br />";

    $message2.="Sincerely,<br />
							  The " . SITE_NAME . " Team";

    $subject1 = SITE_NAME . "[Congratulation!!! You sold " . $row1['product_name'] . " product to " . $data1['username'] . " ";

    SendEMail($from_email1, $to_email1, $subject1, $message2);

    $from_email2 = " " . SITE_NAME . "<" . FROM_EMAIL . ">";
    $to_email2 = TO_ADMIN;

    $message3 = "Hallo " . SITE_NAME . "<br /><br />
		          One Product sold from " . $row2['username'] . " to " . $data1['username'] . "<br />
							Payment Amount: $" . number_format($row1['p_amt'], 2) . "<br />
							Shipping Amount: $" . number_format($row1['shipping_amt'], 2) . "<br />
							Total Amount: $" . number_format($row1['total_amt'], 2) . "<br />
							Product Name: " . $row1['product_name'] . "<br />
							Payment Date: " . date('d/m/Y', strtotime($row1['order_date'])) . "<br /><br />";

    $message3.="Sincerely,<br />
							  The " . SITE_NAME . " Team";

    $subject2 = SITE_NAME . " Product Purchased ";

    SendEMail($from_email2, $to_email2, $subject2, $message3);

    header('location:order_success.php');
}
include('_includes/header.php');
?>
<p align="center">
<h3 align="center">please wait...</h3>
<?php /* ?><img src="<?php echo base_url(); ?>images/loading11.gif" style="display:block; margin: 0 auto;width:350px;"/><?php */ ?>
<h3 align="center"> you are redirectd to paypal payment getway for payment   </h3>
</p>
<?php
$sql = "SELECT * FROM tbl_orders WHERE id='" . $_GET['id'] . "'";
$result = mysqli_query($link,$sql);
while ($row = mysqli_fetch_array($result)) {
    $price["merchant_price"] = $row['shipping_amt'] + $row['total_amt'];
    $price["total_price"] = $price["merchant_price"] + (($price["merchant_price"] * 12) / 100);
    $sql1 = "SELECT * FROM tbl_users WHERE id='" . $row['seller_id'] . "'";
    $result1 = mysqli_query($link,$sql1);
    while ($row1 = mysqli_fetch_array($result1)) {
        $merchant_details["paypal_id"] = $row1['payment_details'];
    }
}
$admin_paypal_id = FROM_EMAIL;
$pay = new Paypalpayment();
$pay->doPaymant();
// $this->paypal->splitPay();
/* echo $price["merchant_price"].'<br>';
  echo $price["total_price"]; */
?>
<div class="content"><!--START CLASS contant PART -->

    <div class="form_class"><!--START CLASS form_class PART -->

        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	

            <form action="" method="post" id="next">

                <input type="hidden" size="50" maxlength="64" name="email" value="">
                <input type="hidden" name="memo" value="chained" >
                <input type="hidden" name="feesPayer" value="PRIMARYRECEIVER" />
                <input type="hidden" name="currencyCode" value="USD" />
                <input type="hidden" name="order_id" value="<?php echo $_GET['id']; ?>"  />

                <input type="hidden" name="receiveremail[]" size="64" value="<?php echo $merchant_details["paypal_id"] ?>" />
                <input class="smalltext" type="hidden" name="amount[]" value="<?php echo $price["merchant_price"] ?>" />
                <input class="smalltext" type="hidden" name="primary[]" value="false" />

                <input type="hidden" name="receiveremail[]" size="64" value="<?php echo $admin_paypal_id; ?>" />
                <input class="smalltext" type="hidden" name="amount[]" value="<?php echo $price["total_price"] ?>" />
                <input class="smalltext" type="hidden" name="primary[]" value="true" />

            </form>



        </div><!--START DIV CLASS profile_page_wraper-->	

    </div><!--END CLASS form_class PART -->


</div><!--END CLASS contant PART -->
<?php include('_includes/footer.php'); ?>