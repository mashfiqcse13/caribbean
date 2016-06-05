<?php
include('include/application_top.php');
cmslogin();
$MSG = '';
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    $data = array(
        "order_status" => $_POST['order_status'],
        "admin_note" => mysql_real_escape_string($_POST['admin_note'])
    );
    $table = "tbl_orders";
    $parameters = "id='" . $_POST['id'] . "'";

    updateData($data, $table, $parameters);
    $MSG = "Record Updated Sucessfully";
}
?>

<!--<script>

function check_status(){
        var order_status = $("#order_status").val();
        if(order_status == 2){
                $('#order_form').submit();
        }
}
</script>-->

<?php
/// post order
//if(isset($_POST) AND isset($_POST['order_status'])){
//mysql_query("UPDATE `carabiancirclestar`.`tbl_orders` SET `order_status` = '2' WHERE `tbl_orders`.`id` =".$_POST['id']);
//}
?>

<?php include('include/header.php'); ?>


<div class="view_order_manage"><!--START DIV CLASS view_order_manage-->
    <?php if (!empty($MSG)) { ?>
        <?php echo "<p class=\"msg\">" . $MSG . " </p>" ?>
    <?php } ?>

    <?php
    //$query=mysql_query("SELECT * FROM tbl_orders WHERE id='".$_GET['id']."'");
    $query = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name,p.ref_id,p.shipping FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id WHERE tbl_orders.id='" . $_GET['id'] . "'");
    ?>

    <?php
    while ($row = mysql_fetch_assoc($query)) {
        ?>

        <h2 class="order">Order Details&nbsp;/ <?php echo $row['id']; ?></h2>
        <?php /* ?><p><label>Order No:</label><?php echo $row['id']; ?></p>

          <p><label>Date:</label><?php echo $row['order_date']; ?></p>

          <p><label>Product Name:</label><?php echo $row['product_name']; ?></p>

          <p><label>Product Amount:</label>$<?php echo $row['p_amt']; ?></p>

          <p><label>Shipping Amount:</label>$<?php echo $row['shipping_amt']; ?></p>

          <p><label>Total Amount:</label>$<?php echo $row['total_amt']; ?></p><?php */ ?>
        <p><label>Order No:</label><?php echo $row['id']; ?></p>

        <p><label>Date:</label><?php echo $row['order_date']; ?></p>

        <p><label>Product Name:</label><?php echo $row['product_name']; ?></p>

        <p><label>Product Amount:</label>$<?php echo $total = number_format($row['p_amt'], 2); ?></p>

        <?php /* ?><?php
          if($row['shipping_amt']!="0.00")
          {
          ?><?php */ ?>

        <p><label>Shipping Amount:</label>$<?php echo $row['shipping_amt']; ?></p>

        <?php /* ?><?php
          }
          ?><?php */ ?>		 
        <p><label>Total Amount:</label>$<?php echo $all_t = number_format(($row['p_amt'] + $row['shipping_amt']), 2); ?></p>

        <p><label>Seller Amount:</label>$<?php echo number_format(($row['p_amt'] * .75) + ($row['shipping_amt']), 2); ?></p>

        <p><label>Seller Feedback:</label><?php echo $row['seller_feedback']; ?></p>

        <p><label>Buyer Feedback:</label><?php echo $row['buyer_feedback']; ?></p>

        <p><label>Order Status:</label>
            <?php
            if ($row['order_status'] == 0) {
                ?>
                <label style="color:#FF3300;"><?php echo 'Pending'; ?></label>

                <?php
            } elseif ($row['order_status'] == 1) {
                ?>

                <label style="color:#009933;"><?php echo 'Success'; ?></label>

                <?php
            }
            /* elseif($row['order_status']==2)
              {
              ?>
              <label style="color:#6666FF;"><?php echo 'Completed'; ?></label>

              <?php
              } */
            ?>
        </p>
        <form id="order_form" action="" method="post">
            <p><label>Change Order Status:</label>


                <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                <select name="order_status">
                    <option value="0" <?php
                    if ($row['order_status'] == 0) {
                        echo 'selected=selected';
                    }
                    ?>>Pending</option>
                    <option value="1" <?php
                    if ($row['order_status'] == 1) {
                        echo 'selected=selected';
                    }
                    ?>>Success</option>
                            <?php /* ?><option value="2" <?php if($row['order_status']==2){ echo 'selected=selected' ;} ?>>Completed</option><?php */ ?>
                </select>

            </p>
            <p style="height: inherit;">
                <label>Admin Note</label>
                <textarea name="admin_note"><?php echo $row['admin_note'] ?></textarea>
                <input type="submit" name="submit" value="Update" />
            </p>
        </form>
        <!--<br /><br /><hr style="border:2px solid #FF9900;"/><br />-->

        <?php
        $p_id = $row["p_id"];
        $sql_product = "select * from  tbl_products where id='" . $p_id . "'";
        $query_product = mysql_query($sql_product);
        $product_row = mysql_fetch_assoc($query_product);
        ?>

        <h2 class="order">Product Details</h2>

        <div class="product_history"><!--START DIV CLASS product_history-->

            <img src="../_uploads/profile_product/<?php echo $row["p_id"]; ?>.jpg" alt=""/>
            <?php /* ?><?php $iamge="../_uploads/profile_product/".$row['p_id'].".jpg"; 

              if(file_exists($iamge))
              {
              ?>
              <img src=<?php echo $iamge; ?> alt=""/>

              <?php
              }
              ?><?php */ ?>

            <span class="product_name"><?php echo $product_row["product_name"]; ?></span>
            <p class="product_details"><?php echo $product_row['product_details']; ?></p>

            <?php /* ?><div class="product_detailss"><!--START DIV CLASS product_detailss-->

              <h3 class="product_name"><?php echo $product_row["product_name"]; ?></h3>
              <p class="product_details"><?php echo $product_row['product_details'];?></p>

              </div><?php */ ?><!--END DIV CLASS product_detailss-->

            <div style="clear:both"></div>

        </div><!--END DIV CLASS product_history-->



        <!--<br /><br /><hr style="border:2px solid #FF9900;"/><br />-->



        <h2 class="order">Seller Details</h2>

        <div class="seller_details"><!--DIV CLASS START seller_details-->

            <div class="seller_details_left"><!--DIV CLASS START seller_details_left-->
                <?php
                $tbl_user_details = mysql_query("SELECT p.id as prid,u.id,u.first_name,u.last_name,u.email,u.phone_no,u.username FROM  tbl_products as p LEFT OUTER JOIN tbl_users AS u ON 	u.id=p.uid WHERE p.id='" . $p_id . "' ");
                $tbl_row = mysql_fetch_array($tbl_user_details);
                ?>
                <p><label>Seller Username:</label><?php echo $tbl_row['username']; ?></p>
                <p><label>Seller Name:</label><?php echo $tbl_row['first_name']; ?> <?php echo $tbl_row['last_name']; ?></p>
                <p><label>Seller Email:</label><?php echo $tbl_row['email']; ?></p>
                <p><label>Seller Phone:</label><?php echo $tbl_row['phone_no']; ?></p>

            </div><!--DIV CLASS END seller_details_left-->

            <div class="seller_details_right"><!--DIV CLASS START seller_details_right-->

                <p><u>Seller bank information</u></p>

                <?php
                $seller_bank_information = mysql_query("SELECT p.id as prid,tbl_seller_bank.* FROM tbl_products as p LEFT OUTER JOIN  tbl_seller_bank ON
 																	tbl_seller_bank.uid=p.uid WHERE p.id='" . $p_id . "'");

                /* echo "SELECT p.id as prid,tbl_seller_bank.*, FROM tbl_products as p LEFT OUTER JOIN  tbl_seller_bank ON
                  tbl_seller_bank.uid=p.uid WHERE p.id='".$p_id."'"; */
                $seller_bank_row = mysql_fetch_array($seller_bank_information);
                ?>
                <p><label>Bank Name:</label><?php echo $seller_bank_row['bank_name']; ?></p>

                <p><label>Country:</label><?php echo $countries_array1[$seller_bank_row['country']]; ?></p>

                <p><label>Routing Number:</label><?php echo $seller_bank_row['routing_number']; ?></p>

                <p><label>Bank Address:</label><?php echo $seller_bank_row['bank_address']; ?></p>

                <p><label>Bank Address 2:</label><?php echo $seller_bank_row['bank_address_2']; ?></p>	

                <p><label>Bank City:</label><?php echo $seller_bank_row['bank_city']; ?></p>

                <p><label>Bank State:</label><?php echo $seller_bank_row['bank_state']; ?></p>

                <p><label>Bank Zip Code:</label><?php echo $seller_bank_row['bank_zip_code']; ?></p>

                <p><label style="width:140px;">Account Holder Name:</label><?php echo $seller_bank_row['account_holder_name']; ?></p>

                <p><label>Account IBAN:</label><?php echo $seller_bank_row['accountnumber_iban']; ?></p>

            </div><!--DIV CLASS END seller_details_right-->


        </div><!--DIV CLASS END seller_details-->

        <div style="clear:both;"></div>

        <!--<br /><br /><hr style="border:2px solid #FF9900;"/><br />-->
        <h2 class="order">Buyer Details</h2>

        <?php
        $buyer_details = mysql_query("SELECT t_o.id AS t_o_id,t_o.uid,t_u.id AS t_u_id,t_u.first_name,t_u.last_name,t_u.phone_no,t_u.email,t_u.username FROM  tbl_orders AS t_o LEFT OUTER JOIN  tbl_users AS t_u ON t_o.uid = t_u.id WHERE t_o.id='" . $_GET['id'] . "'");

        $buyer_details_row = mysql_fetch_assoc($buyer_details);
        ?>
        <p><label>Buyer Username:</label><?php echo $buyer_details_row['username']; ?></p>
        <p><label>Buyer Name:</label><?php echo $buyer_details_row['first_name']; ?> <?php echo $buyer_details_row['last_name']; ?></p>
        <p><label>Buyer Email:</label><?php echo $buyer_details_row['email']; ?></p>
        <p><label>Buyer Phone:</label><?php echo $buyer_details_row['phone_no']; ?></p>

        <!--<br /><br /><hr style="border:2px solid #FF9900;"/><br />-->
        <?php
        $tbl_query_shipping = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name,p.ref_id,p.shipping FROM 
													tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id WHERE tbl_orders.id='" . $_GET['id'] . "'");
        $tbl_query_row = mysql_fetch_array($tbl_query_shipping);

        if ($tbl_query_row['shipping'] != 0) {
            ?>

            <h2 class="order">Shipping Details</h2>

            <?php
            $tbl_query123 = mysql_query("SELECT tbl_order_shipping.*, tbl_orders.id FROM tbl_order_shipping LEFT JOIN tbl_orders ON 
											tbl_order_shipping.order_id = tbl_orders.id WHERE tbl_order_shipping.order_id='" . $_GET['id'] . "'");

            if (mysql_num_rows($tbl_query123) > 0) {
                $tbl_row123 = mysql_fetch_array($tbl_query123);
                ?>

                <p><label>Shipping Address :</label><?php echo $tbl_row123['address']; ?></p>
                <p><label>Shipping Zip :</label><?php echo $tbl_row123['zip']; ?></p>
                <p><label>Shipping City :</label><?php echo $tbl_row123['city']; ?></p>
                <p><label>Shipping State :</label><?php echo $tbl_row123['state']; ?></p>					

                <p>
                    <label>Shipping Country:</label>
                    <?php echo $countries_array[$tbl_row123['country']]; ?>               
                </p>



                <?php
            }
        }
    }
    ?>
</div><!--END DIV CLASS view_order_manage-->		

<?php include('include/footer.php'); ?>
