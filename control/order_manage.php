<?php
include('include/application_top.php');
cmslogin();
?>

<?php include('include/header.php'); ?>
<script type="text/javascript">
    function ConfrimMessage_Delete(Url) //confarming property delete
    {
        if (confirm("Are you sure you want to delete this Record?"))
        {
            /*self.navigate(Url);*/ //redirecting to the desired page
            window.location = "" + Url;
        }
    }
</script>
<?php
$query = mysql_query("SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id ORDER BY tbl_orders.id DESC");

//echo " SELECT tbl_orders.id AS o_id,tbl_orders.*,p.id as prid,p.product_name FROM tbl_orders LEFT OUTER JOIN tbl_products AS p ON p.id=tbl_orders.p_id ORDER BY tbl_orders.id DESC";
?>

<table border="1" class="TDContent" cellpadding="10" cellspacing="0" width="950px;">

    <h1>ORDER MANAGE</h1>
    <?php
    if (isset($_GET['op']) AND ( $_GET['op'] == "del")) {
        echo "<p class='err'>Record Deleted Sucessfully</p>";
    }
    ?>

    <thead>
        <tr>

            <th rowspan="2" style="text-align:left; width:10%" >Order No</th>
            <th rowspan="2" style="text-align:left; width:10%">Date</th>
            <th rowspan="2" style="text-align:left; width:20%">Product Name</th>
            <th rowspan="2" style="text-align:left; width:15%">Amount </th>
            <th colspan="3" style="text-align:center; width:15%">Feedback </th>
            <th rowspan="2" style="text-align:left; width:10%">Status</th>						
            <th rowspan="2" style="text-align:center; width:20%">Action</th>

        </tr>
        <tr>
            <th style="text-align:left; width:15%">Seller </th>
            <th style="text-align:left; width:15%">Buyer </th>
            <th style="text-align:left; width:15%">Admin note </th>

        </tr>
    </thead>

    <tbody>
        <?php
        while ($row = mysql_fetch_assoc($query)) {
            ?>
            <tr>
                <td> <?php echo $row['id']; ?> </td>

                <td> <?php echo $row['order_date']; ?> </td>


                <td> <?php echo $row['product_name'] ?> </td>

                <td> $<?php echo $row['total_amt'] ?> </td>

                <td> <?php echo $row['seller_feedback'] ?> </td>
                <td> <?php echo $row['buyer_feedback'] ?> </td>
                <td> <?php echo $row['admin_note'] ?> </td>

                <?php /* ?><td> <?php echo $row['order_status']; ?> </td><?php */ ?>

                <td> <?php
                    if ($row['order_status'] == 0) {
                        ?>
                        <p style="color:#FF3300;"><?php echo 'Pending'; ?></p>

                        <?php
                    } elseif ($row['order_status'] == 1) {
                        ?>

                        <p style="color:#009933;"><?php echo 'Success'; ?></p>

                        <?php
                    }
                    /* elseif($row['order_status']==2)
                      {
                      ?>
                      <p style="color:#6699FF;"><?php echo 'Completed'; ?></p>

                      <?php
                      } */
                    ?>
                </td>

                <td> <a href="view_order_manage.php?id=<?php echo $row['id']; ?>" style="color:#6666FF;"> View </a>
                    <br>
                    <br>
                    <a href="<?php echo "javascript:ConfrimMessage_Delete('delete_order_manage.php?id=$row[id]')"; ?>" style="color:#6666FF;"> Delete </a> </td>
            </tr>		
            <?php
        }
        ?>
    </tbody>
</table>

<?php include('include/footer.php'); ?>
