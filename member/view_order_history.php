<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
include('../_includes/header.php');
?> 
<script language="javascript" type="text/javascript">
    function Update_Feedback(oid, uid)
    {
        var comm = $("#feedback_text").val();
        if ($.trim(comm) == "")
        {
            alert("Enter Feedback/Notes about this Order and then Submit!");
        } else
        {
            //alert("oid="+oid+"&uid="+uid+"&txt="+comm);
            $.ajax({
                type: "POST",
                url: "../leavefeedback.php",
                data: "oid=" + oid + "&uid=" + uid + "&txt=" + comm,
                success: function (result)
                {
                    window.location.reload();
                }});
        }
    }
</script>

<div class="content"><!--START CLASS contant PART-->	

    <p style="text-align:right"><a href="order-history.php" class="button" style="float:left; margin:-5px 0px 5px 0px;" >Back</a></p>

    <div class="form_class"><!--START CLASS form_class PART -->

        <div class="profile_page_wraper"><!--START DIV CLASS profile_page_wraper-->	

            <div class="profile_details" style="width:55%; position:relative; float:left;">


                <?php
                /* echo "SELECT tbl_orders.id AS o_id, tbl_orders.*,p.id as prid, p.product_name, p.ref_id, p.content_type, p.shipping  
                  FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id WHERE tbl_orders.id='".$_GET['id']."'"; */
                $query = mysqli_query($link,"SELECT tbl_orders.id AS o_id, tbl_orders.*,p.id as prid, p.product_name, p.ref_id, p.content_type, p.shipping  
			                    FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id WHERE tbl_orders.id='" . $_GET['id'] . "'");
                ?>

                <?php
                while ($row = mysqli_fetch_assoc($query)) {
                    ?>

                    <h2>Order Details&nbsp;/ <?php echo $row['id']; ?></h2>
                    <p class="style1"><label class="style">Order No:</label><?php echo $row['id']; ?></p>

                    <p class="style1"><label class="style">Date:</label><?php echo $row['order_date']; ?></p>

                    <p class="style1"><label class="style">Product Name:</label><?php echo $row['product_name']; ?></p>

                    <?php /* ?><p><label class="style">Product Amount:</label>$<?php echo $total=(number_format((($row['p_amt'])-(($row['p_amt']*25)/100)), 2)); ?></p><?php */ ?>

                    <p class="style1"><label class="style">Product Amount:</label>$<?php echo $total = number_format($row['p_amt'], 2); ?></p>

                    <?php /* ?> <p><label class="style">CCS Fees:</label>$<?php echo $amount = number_format((($row['p_amt']*25)/100), 2); ?></p><?php */ ?>

                    <p class="style1"><label class="style">Shipping Amount:</label>$<?php echo $row['shipping_amt']; ?></p>

                    <?php /* ?><p><label class="style">Total Amount:</label>$<?php echo $all_t = number_format(($total+$amount+($row['shipping_amt'])), 2); ?></p><?php */ ?>

                    <p  class="style1"><label class="style">Total Amount:</label>$<?php echo $all_t = number_format(($row['p_amt'] + $row['shipping_amt']), 2); ?></p>

                    <p  class="style1"><label class="style">Seller Feedback:</label><?php echo $all_t = $row['seller_feedback']; ?></p>
                    <p  class="style1"><label class="style">Buyer Feedback:</label><?php echo $all_t = $row['buyer_feedback']; ?></p>

                    <p><label class="style">Order Status:</label>

                    <?php if ($row['order_status'] == 0) { ?><p style="color:#FF0033;"><?php echo 'Pending'; ?></p><?php } ?>

                    <?php if ($row['order_status'] == 1) { ?><p style="color:#009933;"><?php echo 'Success'; ?></p><?php } ?></p>
                </div>
                <?php
                // $query=mysqli_query($link,"SELECT * FROM tbl_users WHERE id='".$_GET['id']."'");	
                // $data=mysqli_fetch_array($query);
                if ($_SESSION['is_admin'] != "yes") {
                    ?>

                    <div class="product_feedbacks" style="width:40%; float:left; position:relative;  border:2px solid #999; border-radius:3px; margin-top:50px; padding:5px;">
                        <h3>Write Feedback/Notes</h3>
                        <br/>


                        <form action="<?php $_SERVER['PHP_SELF']; ?>" method="post" id="comment">											
                            <p>
                                <label for="feedback_text" style="width:190px;">Leave a Feedback/Notes:</label>
                                <textarea name="feedback_text" id="feedback_text" class="required" rows="4" cols="45"><?php echo $row['buyer_feedback'];
                    ?></textarea>					
                            </p>																							
                            <input type="hidden" id="orders_id"  name="orders_id"  value="<?php echo $row['id']; ?>"  />
                            <input type="button" name="submit" value="Submit" class="button" onclick="Update_Feedback('<?php echo $row['id']; ?>', '<?php echo $identity; ?>')" />
                        </form>	

                    </div>
                    <?php
                }
                ?>
                <br clear="all" /><br /><hr style="border:2px solid #FF9900;"/><br />

                <?php
                $p_id = $row["p_id"];
                $sql_product = "select * from  tbl_products where id='" . $p_id . "'";
                $query_product = mysqli_query($link,$sql_product);
                $product_row = mysqli_fetch_assoc($query_product);
                ?>

                <h2>Product Details</h2>

                <div class="product_history"><!--START DIV CLASS product_history-->

                    <img src="../_uploads/profile_product/<?php echo $row["p_id"]; ?>.jpg" alt="" />

                    <div class="product_detailss"><!--START DIV CLASS product_detailss-->

                        <label class="style" style="width:60%;"><?php echo $product_row["product_name"]; ?></label><br /><br />

                        <?php echo $product_row['product_details']; ?>

                        <?php /* ?><?php $iamge="../_uploads/profile_product/".$row['p_id'].".jpg"; 

                          if(file_exists($iamge))
                          {
                          ?>
                          <img src=<?php echo $iamge; ?> alt="my_img"/>

                          <div class="product_detailss"><!--START DIV CLASS product_detailss-->

                          <label class="style"><?php echo $product_row["product_name"]; ?></label><br /><br />

                          <?php echo $product_row['product_details'];?>
                          <?php
                          }
                          ?><?php */ ?>

                        <br /><br />

                        <?php
                        //$mp3 = "../_uploads/profile_music/".$row['ref_id'].".mp3";
                        //if(file_exists($mp3)>0)
                        //{
                        //if($product_row['shipping']==0 || $row['content_type']==1 )
                        if (($row['content_type'] == 2 && $row['shipping'] == 0) || ($row['content_type'] == 1)) {
                            ?>

                            <div class="download" style="width:100px;">	

                                <?php
                                if ($row['order_status'] == 1) {
                                    ?>
                                    <a href="download:" id="download_link" style="color:#6666FF; font-weight:bold;font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; ">

                                        <img src="../_images/download.png"  />
                                        <u> Download </u></a></div>
                                <?php
                            }
                            ?>	
                            <br />


                        </div><!--END DIV CLASS product_detailss-->

                    </div><!--END DIV CLASS product_history-->	

                    <?php /* ?><script type="text/javascript">
                      $(function(){
                      $("#download_link").click(function(){
                      window.location.href="<?php echo SITE_URL . "_uploads/profile_music/".$row['ref_id'].".mp3"; ?>";
                      return false;
                      })
                      });
                      </script><?php */ ?>

                    <script type="text/javascript">
                        $(function () {
                            $("#download_link").click(function () {
        <?php if ($row['content_type'] == 1) { ?>

                                    window.location.href = "<?php echo SITE_URL . "_uploads/profile_music/" . $row['ref_id'] . ".mp3"; ?>";
        <?php } ?>

        <?php if ($row['content_type'] == 2) { ?>
                                    window.location.href = "<?php echo SITE_URL . "_uploads/profile_video/" . $row['ref_id'] . ".mp4"; ?>";

        <?php } ?>
                                return false;

                            })
                        });
                    </script>

                    <?php
                } else {
                    ?>

                    <div style="clear:both;"></div>

                </div><!--END DIV CLASS product_detailss-->
            </div><!--END DIV CLASS product_history-->



            <br /><br /><hr style="border:2px solid #FF9900;"/><br />





            <h2>Shipping Details</h2>

            <?php
            $tbl_query123 = mysqli_query($link,"SELECT tbl_order_shipping.*, tbl_orders.id FROM tbl_order_shipping LEFT JOIN tbl_orders ON 
											tbl_order_shipping.order_id = tbl_orders.id WHERE tbl_order_shipping.order_id='" . $_GET['id'] . "'");

            while ($tbl_row123 = mysqli_fetch_array($tbl_query123)) {
                ?>

                <p class="style1"><label class="style">Shipping Address :</label><?php echo $tbl_row123['address']; ?></p>
                <p class="style1"><label class="style">Shipping Zip :</label><?php echo $tbl_row123['zip']; ?></p>
                <p class="style1"><label class="style">Shipping City :</label><?php echo $tbl_row123['city']; ?></p>
                <p class="style1"><label class="style">Shipping State :</label><?php echo $tbl_row123['state']; ?></p>					

                <p class="style1">
                    <label class="style">Shipping Country:</label>
                    <?php echo $countries_array[$tbl_row123['country']]; ?>               
                </p>
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
