<?php
include('../_includes/application-top.php');
ChecktalentLogin();
if ((isset($_POST['submit'])) AND ( $_POST['submit'] == 'Update')) {
    $data = array(
        "seller_feedback" => mysql_real_escape_string($_POST['seller_feedback'])
    );
    $table = "tbl_orders";
    $parameters = "id='" . $_POST['id'] . "'";

    updateData($data, $table, $parameters);
    $MSG = "Record Updated Sucessfully";
}
include('../_includes/header.php');
?> 
<div class="content"><!--START CLASS contant PART-->	

    <p style="text-align:right"><a href="order_manage.php" class="button" style="float:left; margin:-5px 0px 5px 0px;" >Back</a></p>

    <div class="form_class"><!--START CLASS form_class PART -->

        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->
            <table>
                <tbody>
                    <tr>
                        <td>

                            <?php
                            $query = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name,p.ref_id FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id WHERE tbl_orders.id='" . $_GET['id'] . "'");
                            while ($row = mysql_fetch_assoc($query)) {
                                ?>

                                <h2>Order Details&nbsp;/ <?php echo $row['id']; ?></h2>
                                <p class="style1"><label class="style">Order No:</label><?php echo $row['id']; ?></p>

                                <p class="style1"><label class="style">Date:</label><?php echo $row['order_date']; ?></p>

                                <p class="style1"><label class="style">Product Name:</label><?php echo $row['product_name']; ?></p>

                                <?php /* ?><p class="style1"><label class="style">Product Amount:</label>$<?php echo $total=(number_format((($row['p_amt'])-(($row['p_amt']*25)/100)), 2)); ?></p><?php */ ?>

                                <p class="style1"><label class="style">Product Amount:</label>$<?php echo $total = number_format($row['p_amt'], 2); ?></p>

                                <?php /* ?> <p class="style1"><label class="style">CCS Fees:</label>$<?php echo $amount = number_format((($row['p_amt']*25)/100), 2); ?></p><?php */ ?>


                                <p class="style1"><label class="style">Shipping Amount:</label>$<?php echo $row['shipping_amt']; ?></p>

                                <?php /* ?><p class="style1"><label class="style">Total Amount:</label>$<?php echo $all_t = number_format(($total+$amount+($row['shipping_amt'])), 2); ?></p><?php */ ?>

                                <p  class="style1"><label class="style">Total Amount:</label>$<?php echo $all_t = number_format(($row['p_amt'] + $row['shipping_amt']), 2); ?></p>

                                <p  class="style1"><label class="style">Buyer Feedback:</label><?php echo $row['buyer_feedback']; ?></p>
                    <p  class="style1"><label class="style">Seller Feedback:</label><?php echo $all_t = $row['seller_feedback']; ?></p>

                                <p><label class="style">Order Status:</label>
                                <?php if ($row['order_status'] == 0) { ?><p style="color:#FF0033;"><?php echo 'Pending'; ?></p><?php } ?>
                                <?php if ($row['order_status'] == 1) { ?><p style="color:#009933;"><?php echo 'Success'; ?></p><?php } ?></p>

                                <label style="width:250px;">Amount to be recived from ccs:</label><p style="margin-top:20px;">$<?php echo number_format(($row['p_amt'] * .75) + ($row['shipping_amt']), 2); ?></p>
                            </td>
                            <td style="width: 35%; vertical-align: top;">
                                <h2>Seller Feedback</h2>
                                <form id="order_form" action="" method="post">
                                    <br />
                                    <label>Send massage to buyer</label>
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>"  />
                                    <textarea name="seller_feedback" style="width: 191px; height: 87px;"><?php echo $row['seller_feedback']; ?></textarea>                 
                                    <input type="submit" name="submit" value="Update">  
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>


                <br /><br /><hr style="border:2px solid #FF9900;"/><br />

                <?php
                $p_id = $row["p_id"];
                $sql_product = "select * from  tbl_products where id='" . $p_id . "'";
                $query_product = mysql_query($sql_product);
                $product_row = mysql_fetch_assoc($query_product);
                ?>

                <h2>Product Details</h2>

                <div class="product_history"><!--START DIV CLASS product_history-->

                    <img src="../_uploads/profile_product/<?php echo $row["p_id"]; ?>.jpg" alt=""/>

                    <div class="product_detailss"><!--START DIV CLASS product_detailss-->

                        <label class="style" style="width:60%;"><?php echo $product_row["product_name"]; ?></label><br /><br />

                        <?php echo $product_row['product_details']; ?>

                        <?php
                        $mp3 = "../_uploads/profile_music/" . $row['ref_id'] . ".mp3";

                        if (file_exists($mp3) > 0) {
                            ?>

                        </div><!--END DIV CLASS product_detailss-->

                    </div><!--END DIV CLASS product_history-->	

                    <?php
                } else {
                    ?>

                </div><!--END DIV CLASS product_detailss-->

            </div><!--END DIV CLASS product_history-->



            <br /><br /><hr style="border:2px solid #FF9900;"/><br />



            <h2>Buyer Details</h2>

            <?php
            $tbl_user_details = mysql_query("SELECT o.id as prid,u.id,u.username,u.email,u.phone_no FROM   tbl_orders as o LEFT OUTER JOIN tbl_users AS u ON 	u.id=o.uid WHERE o.uid='" . $row["uid"] . "'");
            $tbl_row = mysql_fetch_array($tbl_user_details);
            ?>
            <p class="style1"><label class="style">Buyer Name:</label><?php echo $tbl_row['username']; ?></p>
            <p class="style1"><label class="style">Buyer Email:</label><?php echo $tbl_row['email']; ?></p>
            <p class="style1"><label class="style">Buyer Phone:</label><?php echo $tbl_row['phone_no']; ?></p>




            <br /><br /><hr style="border:2px solid #FF9900;"/><br />

            <h2>Shipping Details</h2>

            <?php
            $tbl_query123 = mysql_query("SELECT tbl_order_shipping.*, tbl_orders.id FROM tbl_order_shipping LEFT JOIN tbl_orders ON 
																		tbl_order_shipping.order_id = tbl_orders.id WHERE tbl_order_shipping.order_id='" . $_GET['id'] . "'");

            while ($tbl_row123 = mysql_fetch_array($tbl_query123)) {
                ?>

                <p class="style1"><label class="style">Shipping Address :</label><?php echo $tbl_row123['address']; ?></p>
                <p class="style1"><label class="style">Shipping Zip :</label><?php echo $tbl_row123['zip']; ?></p>
                <p class="style1"><label class="style">Shipping City :</label><?php echo $tbl_row123['city']; ?></p>
                <p class="style1"><label class="style">Shipping State :</label><?php echo $tbl_row123['state']; ?></p>					
                <p class="style1"><label class="style">Shipping Country :</label><?php echo $countries_array[$tbl_row123['country']]; ?></p>

                <?php
            }
        }
    }
    ?>
</div><!--END DIV CLASS profile_page_wraper-->	
</div><!--END CLASS form_class PART -->

</div><!--END CLASS contant PART-->

<?php
include('../_includes/footer.php');
?>
