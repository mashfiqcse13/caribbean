<?php
include('../_includes/application-top.php');
ChecktalentLogin();
include('../_includes/header.php');
?> 
<div class="content"><!--START CLASS contant PART -->
    <h2>Order Manage</h2>
    <p style="text-align:right"><a href="member.php<?php echo $user_idd; ?>" class="button" style="float:left; margin:-5px 0px 5px 0px;" onclick="return back();">Back</a></p>
    <div class="form_class"><!--START CLASS form_class PART -->
        <!----------------------------QUERY FRO DATABASE--------------------------------->
        <?php
        $query = mysql_query(" SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id AS prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON tbl_orders.p_id = p.id 
			WHERE tbl_orders.seller_id ='" . $_SESSION['talent_id'] . "' ORDER BY tbl_orders.id DESC ");

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

                        <th style="text-align:left; width:10%" >Order No</th>
                        <th style="text-align:left; width:10%">Date</th>
                        <th style="text-align:left; width:20%">Product Name</th>
                        <th style="text-align:left; width:10%">Amount </th>
                        <th style="text-align:left;">Seller Feedback </th>
                        <th style="text-align:left;">Buyer Feedback </th>
                        <th style="text-align:left; width:10%">Status</th>						
                        <th style="text-align:center; width:10%">Action</th>
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
                        <td align="left">
                            <?php if ($row['order_status'] == 0) { ?><p style="color:#FF0033;"><?php echo 'Pending'; ?></p><?php } ?>
                            <?php if ($row['order_status'] == 1) { ?><p style="color:#009933;"><?php echo 'Success'; ?></p><?php } ?> 
                        </td>
                        <td align="center"><a href="view_order_details.php?id=<?php echo $row['id']; ?>" style="color:#6666FF;">&nbsp;View Details</a></td>
                    </tr>
                    <?php
                }
                ?>
            </tbody>
        </table>
    </div>
</div>
<?php
include('../_includes/footer.php');
?>
