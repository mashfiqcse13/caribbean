<?php
include('../_includes/application-top.php');
ChecknontalentLogin();
//die("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
//			p.id=tbl_orders.p_id WHERE tbl_orders.uid='" . $_SESSION['user_id'] . "' AND  tbl_orders.order_status='1'  ORDER BY tbl_orders.id DESC");
include('../_includes/header.php');
?> 
<div class="content"><!--START CLASS contant PART -->

    <h2>Order History</h2>
    <p style="text-align:right"><a href="member.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 5px 0px;" >Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <?php
        //echo $sql_query="SELECT * FROM tbl_orders WHERE uid='".$_SESSION['user_id']."'";
        //$query=mysql_query("SELECT * FROM tbl_orders WHERE uid='".$_SESSION['user_id']."'");
        //$query=mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
        //p.id=tbl_orders.p_id WHERE tbl_orders.uid='".$_SESSION['user_id']."' AND (tbl_orders.order_status='1' OR tbl_orders.order_status='2')  ORDER BY tbl_orders.id DESC");
        $query = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
			p.id=tbl_orders.p_id WHERE tbl_orders.uid='" . $_SESSION['user_id'] . "'  ORDER BY tbl_orders.id DESC");

        //echo "SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON
        //p.id=tbl_orders.p_id WHERE tbl_orders.uid='".$_SESSION['user_id']."' AND  tbl_orders.order_status='1'  ORDER BY tbl_orders.id DESC";
        //$row=mysql_fetch_assoc($query)
        //print_r($row);
        $number = mysql_num_rows($query);
        ?>

        <?php
        if ($number <= 0) {
            echo "<p class='err'>No Record Found!</p>";
        } else {
            ?>

            <table cellpadding="0" cellspacing="0" class="TabUIRecords">
                <thead>
                    <tr>

                        <th style="text-align:left;">Order No</th>
                        <th style="text-align:left;">Date</th>
                        <th style="text-align:left;">Product Name</th>
                        <th style="text-align:left;">Amount </th>
                        <th style="text-align:left;">Seller Feedback </th>
                        <th style="text-align:left;">Buyer Feedback </th>
                        <th style="text-align:left;">Status</th>						
                        <th style="text-align:center;">Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                }
                while ($row = mysql_fetch_assoc($query)) {
                    ?>
                    <tr>
                        <td align="left"><?php echo $row["id"]; ?></td>
                        <td align="left"><?php echo $row["order_date"]; ?></td>
                        <td align="left"><?php echo $row["product_name"]; ?></td>
                        <td align="left">$<?php echo $row['total_amt']; ?></td>
                        <td align="left"><?php echo $row['seller_feedback']; ?></td>
                        <td align="left"><?php echo $row['buyer_feedback']; ?></td>

                        <?php /* ?>	<td align="left">
                          <?php
                          $p_id=$row["p_id"];
                          $sql_product="select product_details from  tbl_products where id='".$p_id."'";
                          $query_product=mysql_query($sql_product);
                          $product_row=mysql_fetch_assoc($query_product);
                          echo substr($product_row['product_details'],0,20);

                          ?>
                          </td><?php */ ?>
                        <td align="left"> <?php
                            /* if($row['order_status']==0)
                              {
                              ?>
                              <p style="color:#FF3300;"><?php echo 'Pending';?></p>

                              <?php
                              } */

                            if ($row['order_status'] == 0) {
                                ?>

                                <p style="color:#FF0033;"><?php echo 'Pending'; ?></p>

                                <?php
                            } elseif ($row['order_status'] == 1) {
                                ?>
                                <p style="color:#009933;"><?php echo 'Success'; ?></p>

                                <?php
                            }
                            ?>
                        </td>
                        <td align="center"><a href="view_order_history.php?id=<?php echo $row['id']; ?>" style="color:#6666FF;">View Details</a> </td>


                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div><!--END CLASS contant PART -->
<?php
include('../_includes/footer.php');
?>
