<?php
include('_includes/application-top.php');
CheckLoginForum();
$sql = "SELECT * FROM tbl_orders WHERE id='" . $_SESSION['OID'] . "'";
$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);
//print_r($row);

$sql1 = "SELECT payment_details FROM tbl_users WHERE id='" . $row['seller_id'] . "'";
$result1 = mysql_query($sql1);
$row1 = mysql_fetch_assoc($result1);
//print_r($row1);
//echo $_SESSION['OID'];
//exit();	
//$data=array(
//			"order_status"=>'1',
//			"payment_status"=>'1'			
//	);
//
//	$table="tbl_orders";
//	$parameters=$_POST['order_id'];
//	updateData($data,$table,$parameters);

$MSG = "Congratulation, Your Payment is Sucessfull.";


include('_includes/header.php');
?>

<div class="content"><!--START CLASS contant PART -->

    <?php
    echo "<p class='msg' align='center'>" . $MSG . "</p>";
    ?>


    <div class="form_class"><!--START CLASS form_class PART -->

        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	
            <h1>Order Details</h1>
            <p>Product Price:&nbsp;$<?php echo $total = (number_format((($row['p_amt']) - (($row['p_amt'] * 25) / 100)), 2)); ?></p>
            <p>Product Shipping:&nbsp;$<?php echo $row['shipping_amt']; ?></p>
            <p>Total = &nbsp;$<?php echo $total = number_format($total + $row['shipping_amt'], 2); ?></p>

            <p><label>Order Status:&nbsp;</label></p>
            <?php
            if ($row['order_status'] == 0) {
                ?>
                <label style="color:#FF3300;"><?php echo 'Pending'; ?></label>

                <?php
            } elseif ($row['order_status'] == 1) {
                ?>

                <label style="color:#009933;"><?php echo 'Success'; ?></label>

            <?php }
            ?><br /><br />
            <?php /* ?><h1>Seller Bank Information:</h1>
              <p><?php echo nl2br($row1['payment_details']); ?></p><?php */ ?>
            <hr style="border:2px solid #FF9900;"/>
            <?php
            if (isset($_SESSION['user_id']) AND $_SESSION['user_id'] != '') {
                ?>
                <a href="member/view_order_history.php?id=<?php echo $_SESSION['OID']; ?>" style="font-size:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif; color:#FF6600;" >View order details Click here</a><br /><br />
                <?php
            } elseif (isset($_SESSION['talent_id']) AND $_SESSION['talent_id'] != '') {
                ?>
                <a href="talents/view_order_history.php?id=<?php echo $_SESSION['OID']; ?>" style="font-size:20px; font-weight:bold; font-family:Georgia, 'Times New Roman', Times, serif; color:#FF6600;" >View order details Click here</a><br /><br />
                <?php
            } else {
                $_SESSION['OID'] = "";
            }
            ?>
            <a href="index.php">Continue Shopping</a>


        </div><!--START DIV CLASS profile_page_wraper-->	

    </div><!--END CLASS form_class PART -->


</div><!--END CLASS contant PART -->

<?php include('_includes/footer.php'); ?>